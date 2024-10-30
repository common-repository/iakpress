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

use App\Joosorol\IAKPress\IAModel\GenericSessionModelInterface;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostUtils;

class GenericSessionModel extends GenericEntryModel implements GenericSessionModelInterface
{
    /**
     * @var GenericSessionModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * GenericSessionModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main GenericSessionModel Instance
     *
     * Ensures only one instance of GenericSessionModel is loaded or can be loaded.
     *
     * @static
     * @return GenericSessionModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        return Constants::IA_GENERIC_SESSION_POST_TYPE;
    }

    protected function cleanMetaValues(array &$values) {
       parent::cleanMetaValues($values);

       unset($values[Option::PASSWORD]);
    }

    protected function getMetaQueryArgs($modelId, $queryVars = array()) : array {
        return array();
    }

    public function hasFieldValue($formConfigId, $templateId, $modelId, $entryId, $fieldName, $fieldValue, array $requestData) {
        $submitBtnType = intval($requestData[Constants::SUBMIT_BTN_TYPE] ?? 0);

        if ($submitBtnType == FieldRenderType::FORM_BTN_LOG_IN_TYPE ||
            $submitBtnType == FieldRenderType::FORM_BTN_RESET_PASSWORD_TYPE ||
            $submitBtnType == FieldRenderType::FORM_BTN_SIGN_UP_TYPE) {
                
            $args = [
                'post_type' => $this->getPostType($formConfigId, $templateId),
                'posts_per_page'   => 2,
                'paged' => 1,

                'meta_query' => [
                    [
                        'key'     => Constants::SUBMIT_BTN_TYPE,
                        'value'   => $submitBtnType,
                    ],
        
        
                    [
                        'key'     => $fieldName,
                        'value'   => $fieldValue,
                    ]
                ]
            ];

            $query = new \WP_Query($args);

            while ($query->have_posts()) {
                $post = $query->next_post();
                if (intval($post->ID) != intval($entryId)) {
                    return true;
                }
            }
        }      

        return false;
    }

    protected function getEntryBy(int $formConfigId, int $submitBtnType, string $fieldName, string $fieldValue)  : array {
        $query = new \WP_Query([
            "post_type" => $this->getPostType(),
            'meta_query' =>  [
                [
                    'key'     => Constants::SUBMIT_BTN_TYPE,
                    'value'   =>  $submitBtnType
                ],

                [
                    'key'     => $fieldName,
                    'value'   => $fieldValue
                ]
            ]
        ]);
    
        $post = $query->have_posts() ? reset($query->posts) : null;


        if ($post) {
            return $this->fromDb($post, $formConfigId);
        }

        return array();
    }

    public function getEntryByUsername(int $formConfigId, int $submitBtnType, string $username)  : array {
        return $this->getEntryBy($formConfigId, $submitBtnType, Option::USERNAME, $username);
    }

    public function getEntryByEmail(int $formConfigId, int $submitBtnType, string $email)  : array {
        return $this->getEntryBy($formConfigId, $submitBtnType, Option::EMAIL, $email);
    }

    public function addOrUpdateSession(int $formConfigId, array $requestData)  : array {
        $username = $requestData[Option::USERNAME] ?? null;
        $submitBtnType = intval($requestData[Constants::SUBMIT_BTN_TYPE] ?? 0);

        if (!empty($username) && $submitBtnType != 0) {
            $oldEntry = $this->getEntryByUsername($formConfigId, $submitBtnType, $username);
            $entryId = $oldEntry[Constants::ID] ?? 0;
            return $this->doEdit($formConfigId, $entryId, $requestData);
        }

        return array();
    }

    public function resetPassword(int $formConfigId, array $requestData)  : array {
        $email = $requestData[Option::EMAIL] ?? null;
        $submitBtnType = intval($requestData[Constants::SUBMIT_BTN_TYPE] ?? 0);

        if (!empty($email) && $submitBtnType != 0) {
            $user = PostUtils::getInstance()->getUserBy(Option::EMAIL, $email);

            if (!empty($user)) {
                $oldEntry = $this->getEntryByEmail($formConfigId, $submitBtnType, $email);
                $entryId = $oldEntry[Constants::ID] ?? 0;
                return $this->doEdit($formConfigId, $entryId, $requestData);
            }
        }

        return array();
    }
}