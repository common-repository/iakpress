<?php

/*
 * This file is part of the IACAFactory package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\EntryModelMgr;
use App\Joosorol\IAKPress\IAPost\IATemplate\PostTypeUtils;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAModel\ChoiceGroupModelInterface;
use App\Joosorol\IAKPress\IAPost\PluginInterface;

class ChoiceGroupModel extends PostConfigModel implements ChoiceGroupModelInterface
{
    const CATEGORIES_SLUG = "categories";
    const TAGS_SLUG = "tags";
    const OPTIONSGROUP_SLUG = "optionsgroup";


    const MAX_CATEGORY_DEPTH = 5;

    /**
     * @var ChoiceGroupModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * ChoiceGroupModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main ChoiceGroupModel Instance
     *
     * Ensures only one instance of ChoiceGroupModel is loaded or can be loaded.
     *
     * @static
     * @return ChoiceGroupModel - Main instance
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
        return Constants::IA_GENERIC_MODEL_POST_TYPE;
    }

    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $start = intval($queryVars[Constants::START] ?? '0');
        $limit = Constants::POST_CONFIG_LIMIT;
        $s = $queryVars['s'] ?? '';
        $typesStr = $queryVars['types']  ?? '';
        $types = !empty($typesStr) ? explode(",", $typesStr) : array();
    

        if ($limit === 0) {
            $limit = Constants::DEFAULT_LIMIT;
        }

        $pageNumber  = intval($start / $limit) + 1;

        $modelId = intval($queryVars[Constants::MODEL_ID] ?? $formConfigId);

        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'modified',
            'order' => 'DESC',
            'posts_per_page'   => $limit,
            'paged' => $pageNumber,
            's' => $s
        ];

        $typesQuery = [];
        if (!empty($types)) {
            foreach($types as $type) {
                $tab = [];
                $tab[] = [
                    'key'     => PostConfig::POST_CONFIG_TYPE,
                    'value'   => $type
                ];
            }

            $typesQuery = array_merge(
                [
                    'relation' => 'OR'
                ],
                $tab
            );
        }

        
        $args['meta_query'] =  array_merge([
            'relation' => 'AND',
            [
                'key'     => Constants::MODEL_ID,
                'value'   => $modelId
            ],
            $typesQuery
        ]);
        

      
        $result = $this->doFetchList($formConfigId,  $args, $entry);

        $this->getPostListFields($result);

        return $result;
    }


    public function fetchModelsByFormConfig($formConfigId, $userCanManage = false)
    {
        $models = array();
        
        if (intval($formConfigId) != 0) {
            $args = [
                'post_type' => $this->getPostType(),
                'post_parent' => $formConfigId,
                'orderby' => 'post_modified',
                'order' => 'DESC',
                'posts_per_page'   => -1
            ];
    
            $result = $this->doFetchList($formConfigId,  $args);
            $this->getPostListFields($result);
            $entries = $result[Constants::ENTRIES] ?? array();
    
            
           
            foreach ($entries as $k => $v) {
                $modelType = $v[PostConfig::POST_CONFIG_TYPE] ?? 0;

                $entryMgr = EntryModelMgr::getInstance()->getModelByPostType(Constants::IA_GENERIC_ENTRY_POST_TYPE, 0, $modelType);

                if ($entryMgr) {
                    $models[$k] = array_merge($v, [
                        Constants::ENTRIES =>
                        PostTypeUtils::formatPostTypeEntries(
                            $modelType,
                            $entryMgr->fetchList(
                                $formConfigId,
                                array(),
                                [
                                    Constants::MODEL_ID => $k,
                                    Constants::TEMPLATE_ID => $modelType ,
                                    PostConfig::POST_CONFIG_PARENT_ID => $formConfigId
                                ]),
                            $userCanManage)
                    ]);
                }
            }    
        }
       
        return $models;
    }

    public function isIAKCustomPostType() : bool {
        $post_type =  get_query_var('post_type');     
        $currentFormConfig = PluginInterface::getInstance()->getCustomPostType($post_type);

        return !is_null($currentFormConfig);
    }

    public function fetchGroupAndEntries($groupId, array $queryVars = array()): array
    {
        if (intval($groupId) != 0) {
            $formConfig = $this->fetchSingle($groupId);

            if (!empty($formConfig)) {
                $modelType =intval($formConfig[PostConfig::POST_CONFIG_TYPE] ?? 0);
                $fieldType = intval($queryVars[Option::FIELD_TYPE] ?? 0);

                if (TemplateTypes::isTaxonomy($modelType) && $fieldType != 0) {
                    $datalist = TaxonomyModel::getInstance()->getAllTerms($modelType, $groupId);
                    $entries = $datalist[Constants::ENTRIES] ?? array();
                } else {
                    $entryMgr = EntryModelMgr::getInstance()->getModelByPostType(Constants::IA_GENERIC_ENTRY_POST_TYPE, $groupId, $modelType);
                    if ($entryMgr) {
                        $result = $entryMgr->fetchList(
                            $groupId,
                            array(),
                            array_merge(
                                [
                                    Constants::MODEL_ID => $groupId,
                                    Constants::TEMPLATE_ID => $modelType,
                                    PostConfig::POST_CONFIG_PARENT_ID => $groupId
                                ],
                                $queryVars
                            )
                        );

                        $entries = PostTypeUtils::formatPostTypeEntries(
                            $modelType,
                            $result
                        );
                    } else {
                        $entries = array();
                    }
                }

                return array_merge(
                        $formConfig,
                        [
                            Constants::ENTRIES => $entries
                        ]
                    );
            }
        }

        return array();
    }

    public function getAllDataListByGroupId(int $groupId, array $fieldAttrs = array()) { 
        $data = $this->fetchGroupAndEntries($groupId, $fieldAttrs);


        if (isset($data[Option::ID])) {
            return [
                Option::DATALIST => [
                    $data[Option::ID] => $data
                ]
            ];
        } else {
            return [
                Option::DATALIST => array()
            ];
        }
    }



    public function fetchCPTList()
    {
        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'post_modified',
            'order' => 'DESC',
            'posts_per_page'   => -1,
            'meta_query' => TemplateTypes::getCPTMetaQuery()
        ];

        $result =  $this->doFetchList(0, $args);

        return  $result[Constants::ENTRIES] ?? array();
    }

    public function fetchSingleCPT($cptName)
    {
        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'post_modified',
            'order' => 'DESC',
            'posts_per_page'   => 1,
            'meta_query' => array(
                array(
                    'key' => Option::CPT_NAME,
                    'value' =>$cptName
                )
            )
        ];

        $result =  $this->doFetchList(0, $args);

        $entries = $result[Constants::ENTRIES] ?? array();

        return count($entries) > 0 ? $entries[0] : null;
    }

    public function buildCategoriesTaxonomySlug($cptName) : string {
        return  sprintf("%s-%s", $cptName, self::CATEGORIES_SLUG);
    }

    public function buildTagsTaxonomySlug($cptName) : string {
        return  sprintf("%s-%s", $cptName, self::TAGS_SLUG);
    }

    public function buildOptionGroupsTaxonomySlug($cptName) : string {
        return  sprintf("%s-%s", $cptName, Option::OPTIONGROUP);
    }

    public function addSubChoiceGroups($post, int $modelTemplateId, array $values) : array {
        $res = array();

        $cptName = $values[Option::CPT_NAME] ?? null;

        $cptObj = null;

        // create custom post type
        $cptType = 0;
        if (!empty($cptName)) {
            $cptType = $modelTemplateId == TemplateTypes::FT_PRODUCT_LIST_VIEW_FORM 
                ? TemplateTypes::FT_MODEL_PRODUCT_LIST : TemplateTypes::FT_MODEL_CUSTOM_LIST;
            
            $errors = array();
            $cptObj = $this->doEdit(
                0,
                0, 
                [
                    Option::TITLE => $post->post_title,
                    Option::TYPE => $cptType,
                    Option::CPT_NAME => $cptName,
                    Option::CPT_VIEW_ID => $post->ID,
                    Constants::MODEL_ID => 0,
                    Constants::TEMPLATE_ID => 0,
                    Option::PARENT_ID => 0
                ],
                $errors
            );

            $res[Option::CPT_NAME] = $cptObj;
        }

        if (!empty($cptObj)) {
            $cptId = $cptObj[Option::ID] ?? 0;
            $cptFields = $cptObj[PostConfig::FIELDS] ?? array();

            
            // Handle categories taxonomy creation
            $cptCategoryTaxonomy = $this->buildCategoriesTaxonomySlug($cptName);
            $title = FieldLabels::translate(Option::CATEGORIES);
            $obj = $this->createTaxonomy($cptCategoryTaxonomy, $cptCategoryTaxonomy, $title, $cptId, true);
            $catField = $cptFields[Option::PRIMARY_CATEGORY] ?? array();
            if (!empty($catField)) {
                // update ref to datalist
                $this->updatePostMeta($catField[Option::ID], Option::MODEL_ID, intval($obj[Option::ID]));
            }


             if ($cptType === TemplateTypes::FT_MODEL_PRODUCT_LIST) {
                // Handle tags taxonomy creation
                $cptTagsTaxonomy = $this->buildTagsTaxonomySlug($cptName);
                $title = FieldLabels::translate(Option::TAGS);
                $obj = $this->createTaxonomy($cptTagsTaxonomy, $cptTagsTaxonomy, $title, $cptId);
                $catField = $cptFields[Option::TAG] ?? array();
                if (!empty($catField)) {
                    // update ref to datalist
                    $this->updatePostMeta($catField[Option::ID], Option::MODEL_ID, intval($obj[Option::ID]));
                }

                // Handle optiongroup model creation
                $cptOptionGroupsTaxonomy = $this->buildOptionGroupsTaxonomySlug($cptName);
                $title = FieldLabels::translate(Option::OPTIONGROUPS);
                $obj = $this->createOptionGroupModel($cptOptionGroupsTaxonomy, $cptOptionGroupsTaxonomy, $title, $cptId);
                $optGroupField = $cptFields[Option::OPTIONGROUP] ?? array();
                if (!empty($optGroupField)) {
                    // update ref to datalist
                    $this->updatePostMeta($optGroupField[Option::ID], Option::MODEL_ID, intval($obj[Option::ID]));
                }
             }
        }

        return $res;
    }


    protected function createTaxonomy(
        string $cptName,
        string $cptTaxonomy,
        string $title,
        int $modelId,
        bool $isCategory = false
        ) {
        $errors = array();

        $catDepth = $isCategory ? self::MAX_CATEGORY_DEPTH : 1;

        $obj = $this->doEdit(
            0,
            0, 
            [
                Option::TITLE => $title,
                Option::TYPE => $isCategory ? TemplateTypes::FT_MODEL_CATEGORY_LIST : TemplateTypes::FT_MODEL_TAG_LIST,
                Option::CPT_NAME => $cptName,
                Option::CPT_TAXONOMY => $cptTaxonomy,
                Option::CATEGORY_DEPTH => $catDepth,
                Constants::MODEL_ID => $modelId,
                Option::PARENT_ID => $modelId,
                Constants::TEMPLATE_ID => 0
            ],
            $errors
        );

        return $obj;
    }

    protected function createOptionGroupModel(
        string $cptName,
        string $cptTaxonomy,
        string $title,
        int $modelId
        ) {
        $errors = array();

        $obj = $this->doEdit(
            0,
            0, 
            [
                Option::TITLE => $title,
                Option::TYPE => TemplateTypes::FT_MODEL_OPTION_GROUP_LIST,
                Option::CPT_NAME => $cptName,
                Option::CPT_TAXONOMY => $cptTaxonomy,
                Option::CATEGORY_DEPTH => 2,
                Constants::MODEL_ID => $modelId,
                Option::PARENT_ID => $modelId,
                Constants::TEMPLATE_ID => 0
            ],
            $errors
        );

        return $obj;
    }
}
