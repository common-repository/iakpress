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
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\PostUtils;

class TaxonomyModel extends GenericEntryModel
{
    /**
     * @var TaxonomyModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * TaxonomyModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main TaxonomyModel Instance
     *
     * Ensures only one instance of TaxonomyModel is loaded or can be loaded.
     *
     * @static
     * @return TaxonomyModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function fromDb($term, $formConfigId = 0, $modelId = 0): array
    {
        // get meta values
        $theModelId = $modelId != 0 ? $modelId : $formConfigId;
        $fields = FieldConfigModel::getInstance()->getListByName($theModelId);

        $meta = array();
        $tab = $this->getPostMeta($term->term_id, '', true);
        foreach ($tab as $fieldName => $fieldValues) {
            if (
                isset($fields[$fieldName]) ||
                isset(self::IAK_FIELDS[$fieldName])
            ) {
                if (!empty($fieldValues)) {
                    $meta[$fieldName] = $fieldValues[0];
                }
            }
        }

        unset($meta[Option::TEMPLATE_ID]);
        unset($meta[Option::PARENT_ID]);
        unset($meta[Option::MODEL_ID]);

        return array_merge(
            [
                SubPostType::ID => $term->term_id,
                SubPostType::TITLE => html_entity_decode($term->name),
                Option::SLUG => $term->slug,
                Option::NAME => $term->slug,
                Option::DESC => $term->description
            ],
            $meta
        );
    }


    public function toDb(array $values, $formConfigId = 0): PostData
    {
        $formData = new PostData();

        $formData->setPostType($this->getPostType($formConfigId));
        $formData->setPostParent(intval($formConfigId));
        $formData->setPostTitle(trim($values[SubPostType::TITLE] ?? ''));
        $formData->setPostContent(trim($values[Option::DESC] ?? ''));
        $formData->setMenuOrder(intval($values[SubPostType::MENU_ORDER] ?? '0'));

        unset($values[SubPostType::ID]);
        unset($values[SubPostType::TITLE]);
        unset($values[Option::DESC]);
        unset($values[Option::NAME]);
        unset($values[Option::PARENT_ID]);
        unset($values[Option::TEMPLATE_ID]);

        $formData->setMetaValues($values);

        if (strlen($formData->getPostTitle()) < 2) {
            $formData->setIsValid(false);
            return $formData;
        }

        $formData->setIsValid(true);
        return $formData;
    }

    public function getById($id, $formConfigId = 0)
    {
      $entry = get_term($id);
  
      if ($entry) {  
        return $this->fromDb($entry, $formConfigId);
      } else {
        return null;
      }
    }

    /**
     * Create content
     * @param PostData $data
     * @return WP_Post
     */
    public function doCreate($formConfigId, PostData $data, array &$errors)
    {
        $taxonomy = $this->getTaxonomy($data->getMetaValues());
        

        if (!empty($taxonomy)) {
             // Create the term object
            $args = array();
            if (!empty($data->getPostContent())) {
                $args['description'] = $data->getPostContent();
            }

            if (isset($data->getMetaValues()[Option::SLUG])) {
                $args[Option::SLUG] = sanitize_text_field($data->getMetaValues()[Option::SLUG]);
                unset($data->getMetaValues()[Option::SLUG]);
            }

            if (isset($data->getMetaValues()[Constants::PNODE_ID])) {
                $args[Option::PARENT] = intval($data->getMetaValues()[Constants::PNODE_ID]);
                unset($data->getMetaValues()[Constants::PNODE_ID]);
            }

            $res = wp_insert_term(wp_strip_all_tags($data->getPostTitle()), $taxonomy,  $args);
            //delete_option("classified-category_children");

            if (!($res instanceof \WP_Error)) {
                $termId = intval($res['term_id']);
                return PostUtils::getInstance()->getTermById($termId, $taxonomy);
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
     */
    public function doUpdate($formConfigId, PostData $data, array &$errors)
    {
        $args = array(
            'ID'            => $data->getId(),
            'name'    => wp_strip_all_tags($data->getPostTitle())
        );

        if (!empty($data->getPostContent())) {
            $args['description'] = $data->getPostContent();
        }

        if (isset($data->getMetaValues()[Option::SLUG])) {
            $args[Option::SLUG] = sanitize_text_field($data->getMetaValues()[Option::SLUG]);
            unset($data->getMetaValues()[Option::SLUG]);
        }

         $args[Constants::MODEL_ID] = $data->getMetaValues()[Constants::MODEL_ID] ?? 0;

        return $this->updatePost($formConfigId, $args, $data->getMetaValues());
    }

    public function updatePostMeta(int $postId, string $metaKey, $metaValue)
    {
        PostUtils::getInstance()->updateTermMeta($postId, $metaKey, $metaValue);
    }

    public function getPostMeta(int $postId, string $key = '', bool $single = false)
    {
        return PostUtils::getInstance()->getTermMeta($postId, $key, $single);
    }

    public function deletePostMeta(int $postId, string $key)
    {
        PostUtils::getInstance()->deleteTermMeta($postId, $key);
    }

    protected function getTaxonomy($queryVars) : ?string {
        $modelId = intval($queryVars[Constants::MODEL_ID] ?? 0);

        return $modelId != 0 ? PostUtils::getInstance()->getPostMeta($modelId,  Option::CPT_TAXONOMY, true) : null;
    }

    public function deletePost($formConfigId, int $postId, bool $forceDelete = false, $queryVars = array())
    {
        $taxonomy = $this->getTaxonomy($queryVars);
        
        if (!empty($taxonomy)) {
            PostUtils::getInstance()->deleteTerm($postId, $taxonomy);
        }
    }

    public function updatePost($formConfigId, $formData, array $queryVars = array())
    {
        $termId = intval($formData['ID']);
        unset($formData['ID']);

        $taxonomy = $this->getTaxonomy($queryVars);

        if (!empty($taxonomy)) {
            $res = wp_update_term($termId, $taxonomy,  $formData);

            if (!($res instanceof \WP_Error)) {
                return PostUtils::getInstance()->getTermById($termId, $taxonomy);
            }
        }

        return null;
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

        $term = $this->doCreateOrUpdate($formConfigId, $formData, $requestData);

        if (!is_null($term)) {
            $meta = $formData->getMetaValues();

            // remove obsolete options
            if (intval($entryId) != 0) {
                $oldMeta = $this->getPostMeta($term->term_id, '', true);

                foreach ($oldMeta as $fieldName => $oldFieldValues) {
                    if (!empty($oldFieldValues)) {
                        $oldFieldVal = $oldFieldValues[0];

                        if (!isset(EntryModel::IAK_FIELDS[$fieldName])) {
                            if (!isset($meta[$fieldName])) {
                                $this->deletePostMeta($term->term_id, $fieldName);
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
            $this->updateOrGetMetaRows($formConfigId, $theModelId, $term->term_id, $meta, $metaRows);
        } else {
            $errors[Option::TITLE] = AdminLabels::FIELD_VALUE_ALREADY_USED;
        }

        return $term;
    }


    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $entries = [];
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
                );

                $pNodeId = intval($queryVars[Constants::PNODE_ID] ?? 0);


                if ($pNodeId == 0) {
                    $args[Option::PARENT] = 0;
                } else {
                    $args['meta_key'] = Constants::PNODE_ID;
                    $args['meta_value'] = $pNodeId;
                }

                $terms = get_terms($args);
               
                if ( ! is_wp_error( $terms ) ) {
                    foreach ($terms as $term) {
                        $entries[] = $this->fromDb($term, $formConfigId, 0);
                        $count++;
                    }
                }
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
        $entries = [];
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
                    'hide_empty'             => 0
                );

                $terms = get_terms($args);
                              
                if ( ! is_wp_error( $terms ) ) {
                    foreach ($terms as $term) {
                        $entry = $this->fromDb($term, $formConfigId, 0);
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
        ];
    }

    public function getCategoryTerms($formConfigId, array $queryVars = array())
    {
        $entries = [];
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
        ];
    }

    private function getChildren(int $formConfigId, string $taxonomy, int $pNodeId = 0) : array {
        $entries = [];

        $terms = get_terms([
            'taxonomy'               => $taxonomy,
            'order'                  => 'ASC',
            'orderby'                => 'name',
            'hide_empty'             => 0,
            'meta_key'               => Constants::PNODE_ID,
            'meta_value'             => $pNodeId
        ]);


        if ( ! is_wp_error( $terms ) ) {
            foreach ($terms as $term) {
                $entry = $this->fromDb($term, $formConfigId, 0);
                $children = $this->getChildren($formConfigId, $taxonomy, $term->term_id);
                if (!empty($children)) {
                    $entry[Constants::CHILDREN] = $children;
                }

                $entries[$term->term_id] = $entry;
            }
        }

        return $entries;
    }

    public function getAllTerms(int $modelType, int $formConfigId, array $queryVars = array()) : array {
        if ($modelType === TemplateTypes::FT_MODEL_CATEGORY_LIST) {
            return $this->getCategoryTerms($formConfigId);
        } else {
            return $this->search($formConfigId);
        }
    }
}
