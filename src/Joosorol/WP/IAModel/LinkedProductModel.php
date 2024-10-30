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
use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAPostType\LinkedProductPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\PostConfig;

class LinkedProductModel extends GenericEntryModel
{
    /**
     * @var LinkedProductModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * LinkedProductModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main LinkedProductModel Instance
     *
     * Ensures only one instance of LinkedProductModel is loaded or can be loaded.
     *
     * @static
     * @return LinkedProductModel - Main instance
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
        return Constants::IA_LINKED_PRODUCT_POST_TYPE;
    }

    public function getUniqueFields($formConfigId, array $requestData) : array {
        return [
            LinkedProductPostType::REF_ID
        ];
    }

    public function getFieldListByModelId($modelId) : array {
        $obj = new LinkedProductPostType();
        return ($obj->toArray())[PostConfig::FIELDS] ?? array();
    }

    public function hasFieldValue($formConfigId, $templateId, $modelId, $entryId, $fieldName, $fieldValue, array $requestData) {
        $args = [
            'post_type' => $this->getPostType($formConfigId, $templateId),
            'posts_per_page'   => 2,
            'paged' => 1
        ];

        if ($fieldName === LinkedProductPostType::REF_ID) {
            $args['post_parent'] = intval($fieldValue);
        }
        
        $args = array_merge($args, $this->getMetaQueryArgs($modelId, $requestData));

        $query = new \WP_Query($args);
        
        if (intval($entryId) === 0) {
            //var_dump($query->posts);
            //var_dump($query->count);

            return intval($query->count) !== 0;
        }
        
        return false;
    }

    public function toDb(array $values, $formConfigId = 0): PostData
    {
        $formData = new PostData();
        
        $templateId = intval($values[Constants::TEMPLATE_ID] ?? 0);
        $refId = intval($values[LinkedProductPostType::REF_ID] ?? 0);

        $formData->setPostType($this->getPostType($formConfigId, $templateId));
        $formData->setPostParent(intval($refId));

        unset($values[SubPostType::ID]);
        unset($values[SubPostType::TITLE]);
        unset($values[SubPostType::CONTENT]);
        unset($values[SubPostType::INTERNAL_ID]);
        unset($values[Option::POST_PERMALINK]);

        $formData->setMetaValues($values);

        $formData->setIsValid(true);
        return $formData;
    }

    public function fromDb($post, $formConfigId = 0, $modelId = 0): array
    {
        $meta = $this->getMeta($post, $formConfigId, $modelId);
  
        return array_merge(
            [
                SubPostType::ID => $post->ID,
                SubPostType::POST_CONFIG_PARENT_ID => $post->post_parent,
                SubPostType::TITLE => $post->post_title,
                SubPostType::NAME => $post->post_name,
                SubPostType::MENU_ORDER => $post->menu_order
            ],
            $meta
        );
    }

    protected function getQueryArgs($formConfigId, $entry = array(), $queryVars = array()) : array {
        $args = [
            'post_type' => $this->getPostType(),
            'posts_per_page'   => -1
        ];

        $modelId = intval($queryVars[Constants::MODEL_ID] ?? '0');

        $args = array_merge($args, $this->getMetaQueryArgs($modelId, $queryVars));

        return $args;
    }

    protected function getEntriesByRefId($formConfigId, $entry = array(), $queryVars = array())  : array {
        $args = $this->getQueryArgs($formConfigId, $entry, $queryVars);
        
        $query = new \WP_Query($args);

        $res = [];
        
        while ($query->have_posts()) {
          $post = $query->next_post();
          $res[$post->post_parent] = $this->fromDb($post);
        }

        return $res;
    }

    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $entriesByRefId = $this->getEntriesByRefId($formConfigId, $entry, $queryVars);

        if (empty($entriesByRefId)) {
            return $this->buildEmptyFetchListResult();
        } else {
            $queryVars[Constants::POST_IDS] = array_keys($entriesByRefId);
            unset($queryVars[Constants::PNODE_ID]);
            $result = CustomPostTypeModel::getInstance()->fetchAll($formConfigId, $entry, $queryVars);

            $linkedEntries = $result[Constants::ENTRIES] ?? array();

            $newLinkedEntries = array();
            foreach($linkedEntries as  $key => $linkedEntry) {
                $id = $linkedEntry[Option::ID];
                $linkedEntry[LinkedProductPostType::REF_ID]  = $id;

                $entry = $entriesByRefId[$id] ?? null;

                if (!empty($entry)) {
                    $linkedEntry[Option::ID] = $entry[Option::ID] ?? 0;
                }


                $newLinkedEntries[$id] = $linkedEntry;
            }

            $result[Constants::ENTRIES] = $newLinkedEntries;

            return $result;
        }
    }
}