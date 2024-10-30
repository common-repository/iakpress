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

use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use  App\Joosorol\IAKPress\IAPost\Constants;
use  App\Joosorol\IAKPress\IALabel\AdminLabels;
use App\Joosorol\IAKPress\IAModel\PostData;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use App\Joosorol\WP\IAModel\WPContentModel;


abstract class EntryModel extends WPContentModel
{
    const IAK_FIELDS = [
        Constants::FPATH_MEDIA_ID =>  Constants::FPATH_MEDIA_ID,
        Constants::FPATH_FILE =>  Constants::FPATH_FILE,
        Constants::FPATH_THUMBNAIL =>  Constants::FPATH_THUMBNAIL,
        Constants::FPATH_LARGE =>  Constants::FPATH_LARGE,
        Constants::PNODE_ID => Constants::PNODE_ID,
        Constants::MODEL_ID => Constants::MODEL_ID,
        Constants::TEMPLATE_ID => Constants::TEMPLATE_ID,
        Constants::POST_CONFIG_PARENT_ID => Constants::POST_CONFIG_PARENT_ID,
        Constants::SUBMIT_BTN_TYPE => Constants::SUBMIT_BTN_TYPE,
        Constants::SUBMIT_BTN_STEP => Constants::SUBMIT_BTN_STEP,
        Constants::SUBMIT_BTN_NAME => Constants::SUBMIT_BTN_NAME,
        Constants::IP_ADDRESS => Constants::IP_ADDRESS,
        Constants::USER_AGENT => Constants::USER_AGENT,
        Option::CATEGORY_LVL1 => Option::CATEGORY_LVL1,
        Option::CATEGORY_LVL2 => Option::CATEGORY_LVL2,
        Option::CATEGORY_LVL3 => Option::CATEGORY_LVL3,
        Option::CATEGORY_LVL4 => Option::CATEGORY_LVL4,
        Option::CATEGORY_LVL5 => Option::CATEGORY_LVL5,
    ];

    const IAK_CPT_FIELDS = [
        Option::CATEGORY_LVL1 => Option::CATEGORY_LVL1,
        Option::CATEGORY_LVL2 => Option::CATEGORY_LVL2,
        Option::CATEGORY_LVL3 => Option::CATEGORY_LVL3,
        Option::CATEGORY_LVL4 => Option::CATEGORY_LVL4,
        Option::CATEGORY_LVL5 => Option::CATEGORY_LVL5
    ];
    
    public function toDb(array $values, $formConfigId = 0): PostData
    {
        $formData = new PostData();
        
        $templateId = intval($values[Constants::TEMPLATE_ID] ?? 0);

        $formData->setPostType($this->getPostType($formConfigId, $templateId));
        $formData->setPostParent(intval($formConfigId));
        $formData->setPostTitle(trim($values[SubPostType::TITLE] ?? ''));
        $formData->setMenuOrder(intval($values[SubPostType::MENU_ORDER] ?? '0'));

        unset($values[SubPostType::ID]);
        unset($values[SubPostType::TITLE]);
        unset($values[SubPostType::CONTENT]);
        unset($values[SubPostType::INTERNAL_ID]);
        unset($values[Option::POST_PERMALINK]);

        $formData->setMetaValues($values);

        $formData->setIsValid(true);
        return $formData;
    }

    public final function getMeta($post, $formConfigId = 0, $modelId = 0) : array {
        // get meta values
        $theModelId = $modelId != 0 ? $modelId : $formConfigId;
        $fields = $this->getFieldListByModelId($theModelId);

        $meta = array();
        $tab = $this->getPostMeta($post->ID, '', true);
        foreach ($tab as $fieldName=> $fieldValues) {
            $field = $fields[$fieldName] ?? null;
            $fieldType = intval($field ? $field[Option::FIELD_TYPE] : 0);

            if ($field ||
                isset(self::IAK_FIELDS[$fieldName])) {
                if (!empty($fieldValues)) {
                    if ($fieldType == FieldRenderType::BF_TEXTAREA_TYPE) {
                        $meta[$fieldName] = nl2br($fieldValues[0]);
                    } else {
                        $meta[$fieldName] = $fieldValues[0];
                    }
                }
            }
        }

        return $meta;
    }

    public function fromDb($post, $formConfigId = 0, $modelId = 0): array
    {
        $meta = $this->getMeta($post, $formConfigId, $modelId);
  
        return array_merge(
            [
                SubPostType::ID => $post->ID,
                SubPostType::POST_CONFIG_PARENT_ID => $post->post_parent,
                SubPostType::TITLE => html_entity_decode($post->post_title),
                SubPostType::NAME => $post->post_name,
                SubPostType::INTRO => $post->post_excerpt,
                SubPostType::USER_ID => $post->author,
                SubPostType::MENU_ORDER => $post->menu_order,
				SubPostType::CREATED_AT => $post->post_date,
				SubPostType::CREATED_AT_GMT => $post->post_date_gmt,
				SubPostType::UPDATED_AT => $post->post_modified,
				SubPostType::UPDATED_AT_GMT => $post->post_modified_gmt
            ],
            $meta
        );
    }


    /**
     * Add/Update entry
     * @param integer $formConfigId
     * @param integer $entryId
     * @param array $requestData
     * @return array
     */
    public function edit($formConfigId, $entryId, array $requestData)
    {
        $entry = $this->doEdit($formConfigId, $entryId, $requestData);

        return $this->fetchList($formConfigId, $entry, $requestData);
    }

    
    public function getUniqueFields($formConfigId, array $requestData) : array {

        $modelId = intval($requestData[Constants::MODEL_ID] ?? '0');

        $parentConfigType = intval($formConfigId) == intval($modelId) ? Constants::IA_POST_CONFIG_POST_TYPE : Constants::IA_GENERIC_MODEL_POST_TYPE;


        $formConfig = $parentConfigType == Constants::IA_POST_CONFIG_POST_TYPE ?
                    PostConfigModel::getInstance()->fetchSingle($modelId) : ChoiceGroupModel::getInstance()->fetchSingle($modelId);

        $fields = $formConfig[PostConfig::FIELDS] ?? array();
        $settings =  $formConfig[PostConfig::POST_SETTINGS] ?? array();
        $entryTitle = $settings[Option::ENTRY_TITLE] ?? '';
        $entryContent = $settings[Option::ENTRY_CONTENT] ?? '';

        $res = [];
        foreach($fields as $name => $field) {
            $unique =  PostUtils::getInstance()->getBooleanVal($field[Option::UNIQUE] ??  'false');
            if ($unique) {
                if ($name == $entryTitle) {
                    $res[] = Option::POST_TITLE_SEARCH;
                } else if ($name == $entryContent) {
                    $res[] = Option::POST_CONTENT_SEARCH;
                } else {
                    $res[] = $name;
                }
            }
        }

        return $res;
    }

    public function hasFieldValue($formConfigId, $templateId, $modelId, $entryId, $fieldName, $fieldValue, array $requestData) {
        $args = [
            'post_type' => $this->getPostType($formConfigId, $templateId),
            'posts_per_page'   => 2,
            'paged' => 1
        ];

        $metaQuery['meta_query'] = [
            [
                'key'     => Constants::POST_CONFIG_PARENT_ID,
                'value'   => $formConfigId,
            ],

            [
                'key'     => Constants::MODEL_ID,
                'value'   => $modelId,
            ]
        ];

        if ($fieldName == Option::POST_TITLE_SEARCH) {
          $args[Option::POST_TITLE_SEARCH] = $fieldValue;
        } else if ($fieldName == Option::POST_CONTENT_SEARCH) {
            $args[Option::POST_CONTENT_SEARCH] = $fieldValue;
        } else {
            $metaQuery['meta_query'][] =  [
                'key'     => $fieldName,
                'value'   => $fieldValue,
            ];
        }

        $args = array_merge($args, $metaQuery);

        $query = new \WP_Query($args);

        while ($query->have_posts()) {
            $post = $query->next_post();
            if (intval($post->ID) != intval($entryId)) {
                return true;
            }
        }

        return false;
    }


    public function validateForm(int $formConfigId, int $entryId, array $requestData, array &$errors) {
        $modelId = intval($requestData[Constants::MODEL_ID] ?? '0');
        $templateId = intval($requestData[Constants::TEMPLATE_ID] ?? 0);

        $uniqueFields = $this->getUniqueFields($formConfigId, $requestData);
        
        foreach($uniqueFields as $fieldName) {
            $fieldValue = $requestData[$fieldName] ?? '';

            $hasValue = $this->hasFieldValue($formConfigId, $templateId, $modelId, $entryId, $fieldName, $fieldValue, $requestData);
            if ($hasValue) {
                $errors[$fieldName] = AdminLabels::FIELD_VALUE_ALREADY_USED;
            }
        }
    }

    /**
     * Do Add/Update entry
     * @param integer $formConfigId
     * @param integer $entryId
     * @param array $requestData
     * @return \WP_Post | null
     */
    public function doFastEdit($formConfigId, $entryId, array $requestData, array &$errors)
    {
        $formData = $this->toDb($requestData, $formConfigId);

        $formData->setId(intval($entryId));

        $modelId = intval($requestData[Constants::MODEL_ID] ?? '0');
        $templateId = intval($requestData[Constants::TEMPLATE_ID] ?? 0);


        $post = $this->doCreateOrUpdate($formConfigId, $formData, $errors);

        if (!empty($errors)) {
            return null;
        }

        if (!is_null($post)) {
            $meta = $formData->getMetaValues();

            // set template_id
            $meta[Constants::TEMPLATE_ID] = $templateId;
            // set model_id
            $meta[Constants::MODEL_ID] = $modelId;
            // set parent_id
            $meta[Constants::POST_CONFIG_PARENT_ID] = $formConfigId;

             // remove obsolete options
             if (intval($entryId) != 0) {
                $oldMeta = $this->getPostMeta($post->ID, '', true);

                foreach ($oldMeta as $fieldName => $oldFieldValues) {
                   if (!empty($oldFieldValues)) {   
                        if (isset(EntryModel::IAK_CPT_FIELDS[$fieldName])) {
                            if (!isset($meta[$fieldName])) {
                                $this->deletePostMeta($post->ID, $fieldName);
                            }
                        } if (!isset(EntryModel::IAK_FIELDS[$fieldName])) {
                           if (!isset($meta[$fieldName])) {
                               $this->deletePostMeta($post->ID, $fieldName);
                           }
                       }
                   }
                }
             } else { // new entry
                // incr nb_submit
                if (TemplateTypes::isForm($templateId)) {
                    PostConfigModel::getInstance()->incrSubmitCount($formConfigId);
                }
             }
                            
             $metaRows = array();
             $this->updateOrGetMetaRows($formConfigId, $modelId, $post->ID, $meta, $metaRows, false);
        }

        return $post;
    }

    /**
     * Do Add/Update entry
     * @param integer $formConfigId
     * @param integer $entryId
     * @param array $requestData
     * @return array
     */
    public function doEdit($formConfigId, $entryId, array $requestData)
    {
        $errors = array();

        $this->validateForm($formConfigId, $entryId, $requestData, $errors);
        
        if (!empty($errors)) {
            return [
                Constants::RESPONSE_ERRORS => $errors
            ];
        }

        $post = $this->doFastEdit($formConfigId, $entryId, $requestData, $errors);

        if (!is_null($post)) {
            $modelId = intval($requestData[Constants::MODEL_ID] ?? $formConfigId);  
    
            return $this->fromDb($post, intval($formConfigId), intval($modelId));
        }

        return array();
    }


    
    public function updateOrGetMetaRows($formConfigId, $modelId, $entryId, array $meta, array &$metaRows, $get = false) {
        $fields = $this->getFieldListByModelId($modelId);
        
        foreach ($meta as $fieldName => $fieldVal) {            
            if (isset(self::IAK_FIELDS[$fieldName])) {
                if ($get) {
                    $metaRows[] = sprintf("('%s', '%s', '%s')", $entryId, $fieldName, sanitize_text_field($fieldVal));
                } else {
                    $this->updatePostMeta($entryId, $fieldName, sanitize_text_field($fieldVal));
                }
            } else {
                $field = $fields[$fieldName] ?? null;
                $fieldType = intval($field ? $field[Option::FIELD_TYPE] ?? 0  : 0);
                
                if (!is_null($field) || isset(self::IAK_FIELDS[$fieldName])) {
                    if ($fieldType == FieldRenderType::BF_TEXTAREA_TYPE) {
                        if ($get) {
                            $metaRows[] = sprintf("('%s', '%s', '%s')", $entryId, $fieldName, wp_kses_post($fieldVal));
                        } else {
                            $this->updatePostMeta($entryId, $fieldName, wp_kses_post($fieldVal));
                        }
                    } else {
                        if (is_array($fieldVal)) {
                            $tabStr = implode(",", $fieldVal);
                            if ($get) {
                                $metaRows[] = sprintf("('%s', '%s', '%s')", $entryId, $fieldName, sanitize_text_field($tabStr));
                            } else {
                                $this->updatePostMeta($entryId, $fieldName, sanitize_text_field($tabStr));
                            }
                        } else {
                            if ($get) {
                                $metaRows[] = sprintf("('%s', '%s', '%s')", $entryId, $fieldName, sanitize_text_field($fieldVal));
                            } else {
                                $this->updatePostMeta($entryId, $fieldName, sanitize_text_field($fieldVal));
                            }
                        }
                    }
                }
            }
        }
    }

    public static function setTags(int $entryId, int $fieldModelId, $fieldVal) {
        $taxonomy = PostUtils::getInstance()->getPostMeta($fieldModelId, Option::CPT_NAME, true);
        if (!empty($taxonomy)) {
            $ids = is_array($fieldVal) ? $fieldVal : explode(",", $fieldVal);
            $tags = [];
            foreach($ids as $id) {
                $term = PostUtils::getInstance()->getTermById($id, $taxonomy);
                if (!is_null($term)) {
                    $tags[] = $term->name;
                }
            }

            if (!empty($tags)) {
                PostUtils::getInstance()->setPostTerms($entryId, $taxonomy, $tags);
            }                    
        }
    }


    /**
     * Delete entry
     * @param integer $formConfigId
     * @param integer $entryId
     * @return
     */
    public function delete($formConfigId, $entryId, $queryVars = array())
    {
        $this->doDelete($formConfigId, $entryId, $queryVars);
        return $this->fetchList($formConfigId, array(),  $queryVars);
    }

    /**
     * Do Delete entry
     * @param integer $entryId
     * @return
     */
    public function doDelete($formConfigId, $entryId, $queryVars = array())
    {
       $this->deletePost($formConfigId, $entryId, true, $queryVars);
    }

    /**
     * Do Delete entries
     * @param array $ids
     * @return
     */
    public function doMassDelete($formConfigId, array $ids, array $queryVars = array())
    {
       foreach($ids as $key => $entryId) {
          $this->deletePost($formConfigId, intval($entryId), true, $queryVars);
       }
    }
  
    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {        
        $start = intval($queryVars[Constants::START] ?? '0');
        $limit = intval($queryVars[Constants::LIMIT] ?? '0');

        if ($limit === 0 || $limit > Constants::DEFAULT_LIMIT) {
            $limit = Constants::DEFAULT_LIMIT;
        }

        $pageNumber  = intval($start / $limit) + 1;

        $args = [
            'post_type' => $this->getPostType($formConfigId),
            'post_parent' => $formConfigId,
            'orderby' => 'modified',
            'order' => 'DESC',
            'posts_per_page'   => $limit,
            'paged' => $pageNumber
        ];

        $modelId = intval($queryVars[Constants::MODEL_ID] ?? 0);
        $theModelId = $modelId != 0 ? $modelId : $formConfigId;

        return $this->doFetchList($formConfigId, $args, $entry, $theModelId);
    }
    
    public function search($formConfigId, array $queryVars = array())
    {
        return $this->fetchList($formConfigId, array(), $queryVars);
    }
}
