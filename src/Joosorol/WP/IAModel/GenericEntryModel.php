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
use App\Joosorol\IAKPress\IAModel\PostData;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use App\Joosorol\Imagine\ImageFilter;

class GenericEntryModel extends EntryModel
{
    /**
     * @var GenericEntryModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * @var ImageFilter
     */
    private static ?ImageFilter $sImageFilter = null; 

    /**
     * GenericEntryModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main GenericEntryModel Instance
     *
     * Ensures only one instance of GenericEntryModel is loaded or can be loaded.
     *
     * @static
     * @return GenericEntryModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * @required
     */
    public static function setImageFilter($imageFilter): void
    {
        self::$sImageFilter = $imageFilter;
    }


    public function toDb(array $values, $formConfigId = 0): PostData
    {
        $formData = new PostData();

        $modelId = intval($values[Constants::MODEL_ID] ?? '0');
        $theModelId = $modelId != 0 ? $modelId : $formConfigId;

        $entryTitleField = $this->getPostMeta($theModelId, Option::ENTRY_TITLE, true);

        $templateId = intval($values[Constants::TEMPLATE_ID] ?? 0);

        if (!TemplateTypes::isCustomPostType($templateId)) {
            $formData->setPostParent($theModelId);
        }

        $formData->setPostType($this->getPostType($formConfigId, $templateId));

        $formData->setMenuOrder(intval($values[SubPostType::MENU_ORDER] ?? '0'));

        if (!empty($entryTitleField)) {
            $title = $values[$entryTitleField] ?? '';
            $formData->setPostTitle(trim($title));
            unset($values[$entryTitleField]);
        }

        if (TemplateTypes::isCustomPostType($templateId)) {
            $content =  wp_kses_post($values[Option::SHORT_DESC] ?? '');
            $formData->setPostExcerpt ($content);
            unset($values[Option::SHORT_DESC]);
        }

        $entryContentField = $this->getPostMeta($theModelId, Option::ENTRY_CONTENT, true);

        if (!empty($entryContentField)) {
            $content =  wp_kses_post($values[$entryContentField] ?? '');
            $formData->setPostContent($content);
            unset($values[$entryContentField]);
        }
        
        
        $this->cleanMetaValues($values);


        if (TemplateTypes::isTreeModel($templateId) && !isset($values[Constants::PNODE_ID])) {
            $values[Constants::PNODE_ID] = 0;
        }

        $formData->setMetaValues($values);
        
        $formData->setTemplateId($templateId);

        $formData->setIsValid(true);


        return $formData;
    }

    protected function cleanMetaValues(array &$values) {
        unset($values[Option::POST_PERMALINK]);
        unset($values[Constants::FPATH_THUMBNAIL]);
        unset($values[Constants::FPATH_LARGE]);
    }

    public function getModelId($post,  $formConfigId, $modelId) {
        if (intval($modelId) != 0) {
            return $modelId;
        } else {
            $type = $this->getPostMeta($formConfigId, PostConfig::POST_CONFIG_TYPE, true);
            if (TemplateTypes::isForm($type)) {
                return $formConfigId;
            } else {
                return $this->getPostMeta($post->ID, Constants::MODEL_ID, true);
            }
        }
    }
   

    public function fromDb($post, $formConfigId = 0,  $modelId = 0): array
    {
        return $this->doFromDb($post, $formConfigId, $modelId);
    }

    public function doFromDb($post, $formConfigId = 0,  $modelId = 0): array {
        $meta = $this->getMeta($post, $formConfigId,  $modelId);

        $templateId = intval($meta[Option::TEMPLATE_ID] ?? 0);

        $theFormConfigId = intval($formConfigId);

        $mappedMeta = array();

        $isCPT = TemplateTypes::isCustomPostType($templateId);
        $entryTitleField = $theFormConfigId != 0 ? 
                            PostUtils::getInstance()->getPostMeta($theFormConfigId, Option::ENTRY_TITLE, true) : null;

        if ($isCPT) {
            $mappedMeta[Option::TITLE] = html_entity_decode($post->post_title);
        } if (!empty($entryTitleField)) {
            $mappedMeta[Option::TITLE] = html_entity_decode($post->post_title);
        } else {
            $mappedMeta[Option::ULID] = html_entity_decode($post->post_title);
        }

        if (TemplateTypes::isCustomPostType($templateId)) {
            $mappedMeta[Option::SHORT_DESC] = $post->post_excerpt;
        }

        $entryContentField = $theFormConfigId != 0 ?
                                PostUtils::getInstance()->getPostMeta($theFormConfigId, Option::ENTRY_CONTENT, true) : null;

        if (!empty($entryContentField)) {
            $mappedMeta[$entryContentField] =  $post->post_content;
        } else {
            $mappedMeta[Option::DESC] = $post->post_content;
        }
       
        $meta[Option::POST_PERMALINK] = get_permalink($post);


        $nowDate =  new \DateTime(current_time('mysql'));
        $nowDay = $nowDate->format("Y-m-d");

        $postDate = new \DateTime($post->post_date);
        $postDay = $postDate->format("Y-m-d");

        $isSameDay = $nowDay == $postDay;
        
        $createdDate = $isSameDay ?  date_i18n( get_option( 'time_format' ), $postDate->getTimestamp()) 
                                    : date_i18n( get_option( 'date_format' ), $postDate->getTimestamp());
        

                                    
        if (!is_null(self::$sImageFilter)) {
            $fpathMediaId = intval($meta[Constants::FPATH_MEDIA_ID] ?? 0);
            $defaultUrl = $meta[Option::FILE_PATH] ?? "";

            if ($fpathMediaId != 0 && wp_attachment_is_image($fpathMediaId)) {
                $attachment = wp_get_attachment_metadata($fpathMediaId);
                
                if (!empty($attachment)) {
                    if (isset($attachment[Constants::FILE])) {
                        $meta[Constants::FPATH_THUMBNAIL] =  self::$sImageFilter->getThumbnailImageUrl($modelId, $attachment[Constants::FILE],  $defaultUrl);
                        $meta[Constants::FPATH_LARGE] =  self::$sImageFilter->getLargeImageUrl($modelId, $attachment[Constants::FILE],  $defaultUrl);
                    }
                }
            }
        }
       

        return array_merge(
            $meta,
            $mappedMeta,
            [
                SubPostType::ID => $post->ID,
                SubPostType::POST_CONFIG_PARENT_ID => $post->post_parent,
                SubPostType::NAME => $post->post_name,
                SubPostType::MENU_ORDER => $post->menu_order,
				SubPostType::CREATED_AT => $createdDate,
				SubPostType::CREATED_AT_GMT => $post->post_date_gmt,
				SubPostType::UPDATED_AT => $post->post_modified,
				SubPostType::UPDATED_AT_GMT => $post->post_modified_gmt,
                Option::STATUS_ID => $post->post_status
            ]
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
        return $this->doEdit($formConfigId, $entryId, $requestData);
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        return Constants::IA_GENERIC_ENTRY_POST_TYPE;
    }

    protected function getMetaQueryArgs($modelId, $queryVars = array()) : array {
        $templateId = $queryVars[Constants::TEMPLATE_ID] ?? 0;
        $fieldType = intval($queryVars[Option::FIELD_TYPE] ?? 0);

        $nodeParent = $queryVars[Constants::PNODE_ID] ?? $queryVars[Constants::PNODE_ID] ?? null;
        
        $metaQuery['meta_query'] = [];
        if (!empty($nodeParent)) {
            $metaQuery['meta_query'][] =  [
                    'key'     => Constants::PNODE_ID,
                    'value'   => $nodeParent,
                ];
        } else if (TemplateTypes::isTreeModel($templateId) && $fieldType === 0) {
            $metaQuery['meta_query'][] =  [
                'key'     => Constants::PNODE_ID,
                'value'   => 0,
            ];
        }

        $metaQuery['meta_query'][] =  [
            'key'     => Constants::MODEL_ID,
            'value'   => $modelId,
        ];
        

        return $metaQuery;
    }

    protected function getQueryArgs($formConfigId, $entry = array(), $queryVars = array()) : array {
        $start = intval($queryVars[Constants::START] ?? '0');
        $limit = intval($queryVars[Option::ITEMS_PER_PAGE] ?? $queryVars[Constants::LIMIT] ?? '0');
        $s = $queryVars['s'] ?? '';
    
        $templateId = intval($queryVars[Constants::TEMPLATE_ID] ?? 0);

    
        if ($limit === 0 || $limit > Constants::DEFAULT_LIMIT) {
            $limit = Constants::DEFAULT_LIMIT;
        }

        $pageNumber  = intval($start / $limit) + 1;
        $args = [
            'post_type' => $this->getPostType($formConfigId, $templateId),
            'posts_per_page'   => $limit,
            'paged' => $pageNumber
        ];

        if (isset($queryVars[Constants::POST_IDS])) {
            $args['post__in'] = $queryVars[Constants::POST_IDS];
        } else if (!empty($s)) {
            $args['s'] = $s;
        }

        $templateId = intval($queryVars[Option::TEMPLATE_ID] ?? 0);
        if (TemplateTypes::isModel($templateId)) {
            $args["orderby"]  = $queryVars[Option::ITEMS_ORDER_BY] ?? 'post_modified';

        } else {
            $args["orderby"]  = $queryVars[Option::ITEMS_ORDER_BY] ?? 'post_date';
        }

        $args["order"] = $queryVars[Option::ITEMS_ORDER_DIRECTION] ?? 'DESC';


        $modelId = intval($queryVars[Constants::MODEL_ID] ?? '0');
        
        $args = array_merge($args, $this->getMetaQueryArgs($modelId, $queryVars));
        

        return $args;
    }

    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $modelId = intval($queryVars[Constants::MODEL_ID] ?? '0');

        $args = $this->getQueryArgs($formConfigId, $entry, $queryVars);
        
        $theModelId = $modelId != 0 ? $modelId : $formConfigId;

        $list =  $this->doFetchList($formConfigId, $args, $entry, $theModelId);

        return $list;
    }

    public function fetchAll($formConfigId, $entry = array(), $queryVars = array())
    {
        $modelId = intval($queryVars[Constants::MODEL_ID] ?? '0');

        $args = $this->getQueryArgs($formConfigId, $entry, $queryVars);

        unset($args['paged']);
        $args['posts_per_page'] = -1;
        
        $theModelId = $modelId != 0 ? $modelId : $formConfigId;

        $list =  $this->doFetchList($formConfigId, $args, $entry, $theModelId);

        return $list;
    }
}
