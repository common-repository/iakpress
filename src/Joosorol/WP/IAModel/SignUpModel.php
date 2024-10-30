<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;

use App\Joosorol\IAKPress\IAModel\PostData;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use  App\Joosorol\IAKPress\IALabel\AdminLabels;
use App\Joosorol\IAKPress\IAPost\PostUtils;

class SignUpModel extends GenericEntryModel
{
    /**
     * @var SignUpModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * SignUpModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main SignUpModel Instance
     *
     * Ensures only one instance of SignUpModel is loaded or can be loaded.
     *
     * @static
     * @return SignUpModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function validateForm(int $formConfigId, int $entryId, array $requestData, array &$errors)
    {
        $modelId = intval($requestData[Constants::MODEL_ID] ?? '0');
        $templateId = intval($requestData[Constants::TEMPLATE_ID] ?? 0);

        $uniqueFields = $this->getUniqueFields($formConfigId, $requestData);

        foreach ($uniqueFields as $fieldName) {
            $fieldValue = $requestData[$fieldName] ?? '';

            if ($fieldName == Option::USERNAME && username_exists($fieldValue)) {
                $errors[$fieldName] = __("Sorry, that username already exists!");
            } else if ($fieldName == Option::EMAIL && email_exists($fieldValue)) {
                $errors[$fieldName] = __("Sorry, that email address is already used!");
            } else {
                $hasValue = $this->hasFieldValue($formConfigId, $templateId, $modelId, $entryId, $fieldName, $fieldValue, $requestData);
                if ($hasValue) {
                    $errors[$fieldName] = __(AdminLabels::FIELD_VALUE_ALREADY_USED, Constants::IAKPRESS);
                }
            }
        }
    }


    public function getById($id, $formConfigId = 0)
    {
        $user = PostUtils::getInstance()->getUserBy('id', intval($id));

        if ($user) {
            return $this->fromDb($user, $formConfigId);
        } else {
            return null;
        }
    }

    /**
     * Create content
     * @param PostData $data
     * @return WP_User | WP_Error
     */
    public function doCreate($formConfigId, PostData $data, array &$errors)
    {
        $registration = get_option('users_can_register');

        if ($registration || current_user_can('create_users')) {
            $username =  $data->getMetaValues()[Option::USERNAME] ?? null;
            $email = $data->getMetaValues()[Option::EMAIL] ?? null;
            $password = $data->getMetaValues()[Option::PASSWORD] ?? null;

            if (!empty($username) && !empty($email) && !empty($password)) {
                $salt = wp_generate_password(20);
                $activationKey = sha1($salt . $email . uniqid(time(), true));

                $userData = [
                    'user_login' => $username,
                    'user_email' => $email,
                    'user_pass' => $password,
                    "user_activation_key" => $activationKey
                ];

                // create user in wordpress

                $res = wp_insert_user($userData);

                if ($res instanceof \WP_Error) {
                    if (isset($res->errors["existing_user_email"])) {
                        $errors[Option::EMAIL] = $res->errors["existing_user_email"][0];
                    } else if (isset($res->errors["existing_user_login"])) {
                        $errors[Option::USERNAME] = $res->errors["existing_user_login"][0];
                    }
                } else {
                    //wp_new_user_notification($user_id);
                    return get_user_by('id', $res);
                }
            }
        }

        return null;
    }

    /**
     * Update content
     * @param int $formConfigId 
     * @param PostData $data
     * @return WP_Post
     * @param $formConfigId
     * @return WP_User | WP_Error
     */
    public function doUpdate($formConfigId, PostData $data, array &$errors)
    {
        $userId = $data->getId();
        $args = array(
            'ID'            => $data->getId()
        );

        $this->updatePost($formConfigId, $args, $errors);

        return get_user_by('id', $userId);
    }

    public function updatePostMeta(int $postId, string $metaKey, $metaValue)
    {
        update_user_meta($postId, $metaKey, $metaValue);
    }

    public function getPostMeta(int $postId, string $key = '', bool $single = false)
    {
        return get_user_meta($postId, $key, $single);
    }

    public function deletePostMeta(int $postId, string $key)
    {
        delete_user_meta($postId, $key);
    }

    public function deletePost($formConfigId, int $postId, bool $forceDelete = false, $queryVars = array())
    {
        // should not delete user from Sign Up Form
    }

    public function updatePost($formConfigId, $formData, array $queryVars = array())
    {
        return PostUtils::getInstance()->updateUser($formData);
    }

    /**
     * Do Add/Update entry
     * @param integer $formConfigId
     * @param integer $entryId
     * @param array $requestData
     * @return array
     */
    public function doFastEdit($formConfigId, $entryId, array $requestData, array &$errors)
    {
        $formData = $this->toDb($requestData, $formConfigId);

        $formData->setId(intval($entryId));

        $user = $this->doCreateOrUpdate($formConfigId, $formData, $errors);

        if (!empty($errors)) {
            return null;
        }

        if (!is_null($user) && $user instanceof \WP_User) {
            $meta = $formData->getMetaValues();

            unset($meta[Option::USERNAME]);
            unset($meta[Option::EMAIL]);
            unset($meta[Option::PASSWORD]);

            // remove obsolete options
            if (intval($entryId) != 0) {
                $oldMeta = $this->getPostMeta($user->ID, '', true);

                foreach ($oldMeta as $fieldName => $oldFieldValues) {
                    if (!empty($oldFieldValues)) {
                        $oldFieldVal = $oldFieldValues[0];

                        if (!isset(EntryModel::IAK_FIELDS[$fieldName])) {
                            if (!isset($meta[$fieldName])) {
                                $this->deletePostMeta($user->ID, $fieldName);
                            } else if ($oldFieldVal == $meta[$fieldName]) {
                                unset($meta[$fieldName]);
                            }
                        }
                    }
                }
            }

            $theModelId = intval($requestData[Constants::MODEL_ID] ?? '0');

            // set templateId
            $templateId = intval($requestData[Constants::TEMPLATE_ID] ?? '0');
            $meta[Constants::TEMPLATE_ID] = $templateId;
            // set model_id
            $meta[Constants::MODEL_ID] = $theModelId;
            // set parent_id
            $meta[Constants::POST_CONFIG_PARENT_ID] = $formConfigId;

            $metaRows = array();
            $this->updateOrGetMetaRows($formConfigId, $theModelId, $user->ID, $meta, $metaRows);
        } else {
            $errors[Option::TITLE] = AdminLabels::FIELD_VALUE_ALREADY_USED;
        }

        return $user;
    }


    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $entries = [];
        $count = 0;

        if (intval($formConfigId) != 0) {
            if (!isset($queryVars[Constants::MODEL_ID])) {
                $queryVars[Constants::MODEL_ID] = $formConfigId;
            }
        }

        return [
            Constants::COUNT => $count,
            Constants::TOTAL => $count,
            Constants::ENTRIES => $entries,
            Constants::ENTRY => $entry,
            Constants::TOTAL_PAGES => 1,
            Constants::PAGE_NUMBER => 1,
            Constants::ITEMS_PER_PAGE => $count
        ];
    }

    public function search($formConfigId, array $queryVars = array())
    {
        /*$entries = [];
        $count = 0;

        if (intval($formConfigId) != 0) {
            if (!isset($queryVars[Constants::MODEL_ID])) {
                $queryVars[Constants::MODEL_ID] = $formConfigId;
            }

            $taxonomy = $this->getTaxonomy($queryVars);

            if (!empty($taxonomy)) {
                $args = array(
                    'taxonomy'               => $taxonomy,
                    'order'                  => 'ASC',
                    'orderby'                => 'name',
                    'hide_empty'             => 0,
                    'parent'                 => 0
                );

                $terms = get_terms($args);
                              
                if ( ! is_wp_error( $terms ) ) {
                    foreach ($terms as $term) {
                        $entry = $this->fromDb($term, $formConfigId, 0);
                        $children = $this->getChildren($formConfigId, $taxonomy, $term->term_id);
                        if (!empty($children)) {
                            $entry[Constants::CHILDREN] = $children;
                        }

                        $entries[$term->term_id] = $entry;
                        $count++;
                    }
                }
            }
        }

        return [
            Constants::COUNT => $count,
            Constants::TOTAL => $count,
            Constants::ENTRIES => $entries,
            Constants::TOTAL_PAGES => 1,
            Constants::PAGE_NUMBER => 1,
            Constants::ITEMS_PER_PAGE => $count
        ];*/
    }
}
