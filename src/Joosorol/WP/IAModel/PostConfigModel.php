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

use App\Joosorol\IAKPress\IAModel\EntryStatus;
use App\Joosorol\IAKPress\IAModel\PostConfigModelInterface;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostFields;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\PostData;
use App\Joosorol\IAKPress\IAPost\IATemplate\PostTypeUtils;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\WP\IAModel\WPContentModel;

class PostConfigModel extends WPContentModel implements PostConfigModelInterface
{
    const FIELD_NAME_KEY = 'name';

    const GLOBAL_FORMS_TAB = [
       Constants::IAKPRESS_SIGN_UP_FORM_ID => array(Option::TITLE => 'Users', Option::TYPE => TemplateTypes::FT_SIGN_UP_FORM),
       Constants::IAKPRESS_SESSION_FORM_ID => array(Option::TITLE => 'Sessions', Option::TYPE => TemplateTypes::FT_SESSION_FORM),
       Constants::IAKPRESS_ORDER_FORM_ID => array(Option::TITLE => 'Orders', Option::TYPE => TemplateTypes::FT_ORDER_FORM)
    ];

    /**
     * @var PostConfigModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * PostConfigModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main PostConfigModel Instance
     *
     * Ensures only one instance of PostConfigModel is loaded or can be loaded.
     *
     * @static
     * @return PostConfigModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }


    public function toDb(array $values, $formConfigId = 0): PostData
    {
        $formData = new PostData();

        $formData->setPostType($this->getPostType());
        $formData->setId(intval($values[PostConfig::POST_CONFIG_ID] ?? '0'));

        $parentId = intval($values[Option::MODEL_ID] ?? $formConfigId);
        $formData->setPostParent($parentId);

        $formData->setPostTitle(trim($values[PostConfig::POST_CONFIG_TITLE] ?? ''));

        if (strlen($formData->getPostTitle()) < 4) {
            $formData->setIsValid(false);
            return $formData;
        }

        $formData->setIsValid(true);
        return $formData;
    }

    public function fromDb($post, $formConfigId = 0,  $modelId = 0): array
    {
        $meta = array();

        $tab = $this->getPostMeta($post->ID, '', true);

        foreach ($tab as $fieldName => $fieldValues) {
            if (!empty($fieldValues)) {
                if (
                    $fieldName != Constants::EDIT_LOCK &&
                    $fieldName !=  Constants::EDIT_LAST
                ) {
                    $fieldVal = $fieldValues[0];

                    if ($fieldName == PostConfig::POST_CONFIG_INLINE_CSS) {
                        $meta[$fieldName] = html_entity_decode($fieldVal, ENT_QUOTES, 'UTF-8');
                    } else {
                        $meta[$fieldName] = $fieldVal;
                    }
                }
            }
        }


        $postType = intval($meta[PostConfig::POST_CONFIG_TYPE] ?? TemplateTypes::FT_CONTACT_FORM);
        $postPublished = $meta[PostConfig::POST_CONFIG_PUBLISHED] ?? 'false';
        $postLayout =  intval($meta[PostConfig::POST_CONFIG_LAYOUT] ?? $this->getDefaultLayout($postType));
        $parentId = intval($meta[PostConfig::POST_CONFIG_PARENT_ID] ?? 0);
        $modelId = intval($meta[Option::MODEL_ID] ?? 0);

        if (TemplateTypes::isForm($postType)) { // set currency_code and date_locale_code
            if (!isset($meta[Option::CURRENCY_CODE]) || empty($meta[Option::CURRENCY_CODE])) {
                $meta[Option::CURRENCY_CODE] = "USD";
            }
    
            if (!isset($meta[Option::DATE_LOCALE_CODE]) || empty($meta[Option::DATE_LOCALE_CODE])) {
                $meta[Option::DATE_LOCALE_CODE] = "en-US";
            }    
        }
      
        unset($meta[PostConfig::POST_CONFIG_TYPE]);
        unset($meta[PostConfig::POST_CONFIG_PUBLISHED]);
        unset($meta[PostConfig::POST_CONFIG_LAYOUT]);
        unset($meta[Option::REF_ARCHIVE_VIEW_ID]);
        unset($meta[Option::REF_SINGLE_VIEW_ID]);

        $res =  [
            PostConfig::POST_CONFIG_ID => intval($post->ID),
            PostConfig::POST_CONFIG_TITLE => $post->post_title,
            PostConfig::POST_CONFIG_NAME => $post->post_name,
            PostConfig::POST_CONFIG_DESC => $post->post_content,
            PostConfig::POST_CONFIG_TYPE => $postType,
            PostConfig::POST_CONFIG_PARENT_ID => $parentId,
            Option::MODEL_ID => $modelId,
            PostConfig::POST_CONFIG_PUBLISHED => $postPublished,
            PostConfig::POST_CONFIG_LAYOUT => $postLayout,
            PostConfig::UPDATED_AT => $post->post_modified,
            PostConfig::UPDATED_AT_GMT => $post->post_modified_gmt,
            PostConfig::SUBMIT_COUNT => intval($post->comment_count),
            PostConfig::NEW_ENTRIES_COUNT => property_exists($post, PostConfig::NEW_ENTRIES_COUNT) ? intval($post->new_entries_count) : 0,
            PostConfig::POST_SETTINGS => $meta
        ];

        if (TemplateTypes::isForm($postType)) {
            $res[Option::CURRENCY_CODE] = $meta[Option::CURRENCY_CODE];
            $res[Option::DATE_LOCALE_CODE] =  $meta[Option::DATE_LOCALE_CODE];
        }

        if (PluginInterface::getInstance()->getUserCanManage()) {
            $res[Option::POST_PERMALINK] = get_permalink($post);
            $res[Option::POST_EDIT_LINK] = get_edit_post_link($post->ID);
        }

        if (isset($post->post_count_entries)) {
            $res[PostConfig::COUNT_ENTRIES] = $post->post_count_entries;
        }

        $cptName = $meta[Option::CPT_NAME] ?? "";
        if (!empty($cptName)) {
            $archiveLink = get_post_type_archive_link($cptName);
            if (!empty($archiveLink)) {
                $res[Option::CPT_ARCHIVE_LINK] = $archiveLink;
            }
        }

        return $res;
    }

    public function incrSubmitCount($formConfigId)
    {
        $count = intval(PostUtils::getInstance()->getPostMeta($formConfigId, PostConfig::SUBMIT_COUNT, true));
        $count++;

        PostUtils::getInstance()->updatePostMeta($formConfigId, PostConfig::SUBMIT_COUNT, $count);
    }


    /**
     * Add/Update formConfig
     * @param integer $formConfigId
     * @param array $requestData
     * @return array
     */
    public function edit($formConfigId, $entryId, array $requestData)
    {
        $entry = $this->doEdit($formConfigId, $entryId, $requestData);

        return $this->fetchList($formConfigId, $entry);
    }




    /**
     * Called each time a formConfig is created
     */
    protected function onCreated($post, int $modelTemplateId, array $values)
    {
        $postId = $post->ID;
        $modelTpl = PostTypeUtils::getTemplate($modelTemplateId);
        if (!is_null($modelTpl)) {

            // create linked datalist if any
            $linkedDataList = array();
            $isListinPage = TemplateTypes::isCustomListingPage($modelTemplateId);
            if ($isListinPage) {
                $linkedDataList = ChoiceGroupModel::getInstance()
                                    ->addSubChoiceGroups($post, $modelTemplateId, $values);
            }

            // create current form required fields if any

            $defaultFields = $modelTpl->getDefaultFields();

            // get specific section fields

            $orderNum = 0;

            if (!TemplateTypes::isForm($modelTemplateId) || TemplateTypes::isSimpleContactForm($modelTemplateId)) {
                $this->updatePostMeta($postId, Option::ENTRY_TITLE, PostTypeUtils::TITLE_FIELD);
            }

            $this->updatePostMeta($postId, Option::ENTRY_CONTENT, PostTypeUtils::DESC_FIELD);

            if (TemplateTypes::isModel($modelTemplateId)) {
                $this->updatePostMeta($postId, PostConfig::POST_CONFIG_PUBLISHED, 'true');
            }

            foreach ($defaultFields as $field) {
                $field[SubPostType::MENU_ORDER] = $orderNum;
                $field[Option::DELETABLE] = 'false';

                // backup old name to short_name
                $shortName = $field[Option::NAME];
                $field[Option::SHORT_NAME] =  $shortName;

                // update label for PhotoGallery img_list field
                if ($shortName == Option::IMAGE_LIST) {
                    $field[Option::LABEL] =  $post->post_title;
                }


                // set model id
                if ($isListinPage) {
                    if ($shortName == Option::CUSTOM_LIST) {
                        $cptObj = $linkedDataList[Option::CPT_NAME] ?? array();
                        $field[Option::MODEL_ID] =   $cptObj[Option::ID] ?? 0;
                    }
                }

                // modify name to make it uniq
                $field[Option::NAME] = PostTypeUtils::buildFieldSlug($post->post_name, $shortName);

                FieldConfigModel::getInstance()->doAddAndUpdateMeta($postId, $field);

                $orderNum++;
            }
        }
    }

    public function enrichRequestData(array $values)
    {
        return $values;
    }

    public function getTemplateType(array $values)
    {
        $type = $values[Option::POST_CONFIG_TYPE] ?? '0';

        return intval($type) != 0 ? $type : TemplateTypes::FT_MODEL_SIMPLE_LIST;
    }

    public function getDefaultLayout(int $templateId)
    {
        if ($templateId == TemplateTypes::FT_PRODUCT_LIST_VIEW_FORM || $templateId == TemplateTypes::FT_CUSTOM_LIST_VIEW_FORM) {
            FieldRenderType::BOTTOM_ALIGNED_LABELS_TYPE;
        } else {
            return FieldRenderType::TOP_ALIGNED_LABELS_TYPE;
        }
    }

    public function doFastEdit($formConfigId, $entryId, array $requestData, array &$errors)
    {
        $values = $this->enrichRequestData($requestData['values'] ?? $requestData);

        $formData = $this->toDb($values, $formConfigId);
        $formData->setId(intval($entryId));
        // TODO check if data is valid before insert

        $post = $this->doCreateOrUpdate($formConfigId, $formData, $errors);
        if (!is_null($post)) {
            $type = intval($this->getTemplateType($values));

            unset($values[Option::POST_CONFIG_TITLE]);
            unset($values[Option::POST_CONFIG_TYPE]);

            if (intval($entryId) == 0) {
                // set default layout type
                $values[Option::POST_CONFIG_LAYOUT] = $this->getDefaultLayout($type);

                // notify formConfig created
                $this->onCreated($post,  $type, $values);
            }

            $PostFields = new PostFields($type, $values);
            $formDesc = $PostFields->toArray();

            // Update form config meta fields     
            $this->updateMeta($entryId, $post->ID, $formDesc);

            return $post;
        } else {
            return null;
        }
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
        $post = $this->doFastEdit($formConfigId, $entryId, $requestData, $errors);
        if (!is_null($post)) {
            return $this->fetchSingle($post->ID);
        } else {
            return null;
        }
    }

    /**
     * Publish the post
     * @param integer $formConfigId
     * @param array $requestData
     * @return array
     */
    public function publish($formConfigId, array $requestData)
    {
        $entry = $this->getById($formConfigId);

        if (!is_null($entry)) {
            $formConfigType = $entry[PostConfig::POST_CONFIG_TYPE] ?? '';

            if (PostUtils::getInstance()->validatePublishData($formConfigType, $requestData)) {
                foreach ($requestData as $fieldName => $fieldVal) {
                    $this->updatePostMeta($formConfigId, $fieldName, sanitize_text_field($fieldVal));
                }

                $this->updatePostMeta($formConfigId, PostConfig::POST_CONFIG_PUBLISHED, 'true');

                return $this->fetchSingle($formConfigId);
            } else {
                return [
                    PostConfig::POST_CONFIG_PUBLISHED => 'false'
                ];
            }
        }

        return null;
    }

    /**
     * Publish the post
     * @param integer $formConfigId
     * @param array $requestData
     * @return array
     */
    public function unpublish($formConfigId, array $requestData)
    {
        $entry = $this->getById($formConfigId);

        if (!is_null($entry)) {
            $this->updatePostMeta($formConfigId, PostConfig::POST_CONFIG_PUBLISHED, 'false');

            return $this->fetchSingle($formConfigId);
        } else {
            return null;
        }
    }



    /**
     * Delete form config
     * @param integer $formConfigId
     * @param integer $entryId
     * @return
     */
    public function delete($formConfigId, $entryId, $queryVars = array())
    {
        $this->doDelete($formConfigId, $entryId);
        return $this->fetchList($formConfigId, array(), $queryVars);
    }

    /**
     * Do Delete entry
     * @param integer $entryId
     * @return
     */
    public function doDelete($formConfigId, $entryId, $queryVars = array())
    {
        $this->deletePost($formConfigId, $entryId, true);
    }

    /**
     * Do Delete entries
     * @param array $ids
     * @return
     */
    public function doMassDelete($formConfigId, array $ids, array $queryVars = array())
    {
        foreach ($ids as $key => $entryId) {
            FieldConfigModel::getInstance()->deleteFields($entryId);

            $this->deletePost($formConfigId, $entryId, true);
        }
    }

    public function updatePostConfig(array &$requestData, array &$formDesc, array $entryId2InternalIdMap)
    {
        $values = $requestData[PostFields::VALUES_KEY] ?? array();
        $formConfig = $values[PostFields::POST_CONFIG_CONFIG_KEY] ?? array();

        $formConfigId = intval($formConfig[PostConfig::POST_CONFIG_ID]);
        $formTitle = $formConfig[PostConfig::POST_CONFIG_TITLE] ?? '';

        // Update the post
        if (strlen($formTitle) >= PostFields::MIN_POST_CONFIG_TITLE_LEN) {
            $formData = array(
                'ID' => $formConfigId,
                'post_title' => $formTitle
            );
            $this->updatePost($formConfigId, $formData);
        }

        // Update form config meta fields
        $this->updateMeta($formConfigId, $formConfigId, $formDesc);

        return $this->fetchSingle($formConfigId, $entryId2InternalIdMap);
    }

    private function updateMeta($oldPostConfigId, $formConfigId, $formDesc)
    {
        if (!empty($formDesc)) {
            unset($formDesc[PostConfig::FIELDS]);
            unset($formDesc[PostConfig::POST_CONFIG_ID]);
            unset($formDesc[PostConfig::POST_CONFIG_TITLE]);
            unset($formDesc[Option::LABEL]);

            // remove obsolete options
            if (intval($oldPostConfigId) != 0) {
                $oldMeta = $this->getPostMeta($formConfigId, '', true);

                foreach ($oldMeta as $fieldName => $oldFieldValues) {
                    if (!empty($oldFieldValues)) {
                        $oldFieldVal = $oldFieldValues[0];
                        if (
                            $fieldName != Option::ENTRY_TITLE
                            && $fieldName != Option::ENTRY_CONTENT
                            && $fieldName != PostConfig::POST_CONFIG_PUBLISHED
                        ) {
                            if (!isset($formDesc[$fieldName])) {
                                $this->deletePostMeta($formConfigId, $fieldName);
                            } else if (isset($formDesc[$fieldName]) && $oldFieldVal == $formDesc[$fieldName]) { // value not changed ==> no need to update
                                unset($formDesc[$fieldName]);
                            }
                        }
                    }
                }
            }


            foreach ($formDesc as $fieldName => $fieldVal) {

                if (is_array($fieldVal)) {
                    $tabStr = implode(",", $fieldVal);
                    $this->updatePostMeta($formConfigId, $fieldName, sanitize_text_field($tabStr));
                } else if ($fieldName == PostConfig::POST_CONFIG_INLINE_CSS) {
                    $this->updatePostMeta($formConfigId, $fieldName, wp_kses_post($fieldVal));
                } else {
                    $this->updatePostMeta($formConfigId, $fieldName, sanitize_text_field($fieldVal));
                }
            }
        }
    }

    public function getPostFields($formConfigId, array &$form, $entryId2InternalIdMap = array())
    {
        $args = array(
            'post_parent' => $formConfigId,
            'post_type' => FieldConfigModel::getInstance()->getPostType($formConfigId),
            'orderby' => 'menu_order',
            'posts_per_page'   => -1,
            'order' => 'ASC'
        );

        $postList =  get_children($args);
        $fields = array();

        $submitButtonName = '';

        $signUpSectionName = '';

        $nbQuestions = 0;

        $hasSlider = false;
        $containers = [];
        $actions = [];

        foreach ($postList as $k => $post) {
            $entry = FieldConfigModel::getInstance()->fromDb($post, $formConfigId);
            $fieldType = intval($entry[PostFields::FIELD_TYPE] ?? '0');
            $fieldName = $entry[PostFields::FIELD_NAME] ?? '';

            if ($fieldType == FieldRenderType::FORM_BTN_SUBMIT_TYPE) {
                $submitButtonName = $fieldName;
            }

            $parentType = FieldRenderType::getParentTypeId($fieldType);

            if ($parentType == FieldRenderType::SELECT_QUESTION_TYPE) {
                $nbQuestions++;
            }

            if ($parentType == FieldRenderType::SELECT_SLIDER_TYPE) {
                $hasSlider = true;
            }

            if ($parentType == FieldRenderType::SELECT_CONTAINER_TYPE) {
                $containers[] = $fieldName;
                if ($fieldType === FieldRenderType::CONTAINER_SIGN_UP_SECTION_TYPE) {
                    $signUpSectionName = $fieldName;
                }
            } else if ($parentType == FieldRenderType::SELECT_ACTION_TYPE) {
                if ($fieldType == FieldRenderType::ACTION_THANK_YOU_SCREEN_TYPE) {
                    $actions[] = $fieldName;
                }
            }

            $mergedEntry = isset($entryId2InternalIdMap[$post->ID]) ?
                array_merge($entry, [SubPostType::INTERNAL_ID => $entryId2InternalIdMap[$post->ID]]) : $entry;

            $fields[$fieldName] = $mergedEntry;
        }

        // should return a default container section or step
        if (empty($containers)) {
            $containers[] = Option::DEFAULT_FIELD_SECTION;
        }

        $form[PostConfig::FIELDS] = $fields;
        $form[PostConfig::ACTIONS] = $actions;
        $form[PostConfig::CONTAINERS] = $containers;
        $form[PostConfig::SUBMIT_NAME] = $submitButtonName;
        $form[Constants::HAS_SLIDER] = $hasSlider;
        $form[Constants::NB_QUESTIONS] = $nbQuestions;
        $form[PostConfig::NB_ACTIONS] = count($actions);
        $form[PostConfig::NB_CONTAINERS] = count($containers);
        $form[PostConfig::SIGNUP_SECTION] = $signUpSectionName;


        return $form;
    }

    public function fetchSingle($formConfigId, $entryId2InternalIdMap = array())
    {
        $entry =  $this->getById($formConfigId);

        if (!is_null($entry)) {
            $this->getPostFields($formConfigId, $entry, $entryId2InternalIdMap);

            return $entry;
        }

        return null;
    }

    public function fetchSingleByName($formName)
    {
        $post =  PostUtils::getInstance()->getPostBySlug($formName, $this->getPostType());

        if (!is_null($post)) {
            $entry = $this->fromDb($post);
            $this->getPostFields($post->ID, $entry);

            return $entry;
        }

        return null;
    }

    public function fetchParent($formConfigId)
    {
        $post = WPContentModel::doFindById($formConfigId);
        if ($post) {
            $entry = $this->fromDb($post, $formConfigId);
            $this->getPostFields($formConfigId, $entry);
            return $entry;
        } else {
            return null;
        }
    }

    public function getPostListFields(array &$result)
    {
        $entries = $result[Constants::ENTRIES];

        $newEntries = [];
        foreach ($entries as $form) {
            $formConfigId = $form[PostConfig::POST_CONFIG_ID] ?? 0;
            $updatedPost = $this->getPostFields($formConfigId, $form);

            $models = ChoiceGroupModel::getInstance()->fetchModelsByFormConfig($formConfigId);

            $updatedPost[PostConfig::MODELS] = $models;

            $newEntries[$formConfigId] = $updatedPost;
        }

        $result[Constants::ENTRIES] = $newEntries;

        return $result;
    }

    private function fetchFormList($formConfigId, $entry = array(),  $queryVars = array())
    {
        global $wpdb;

        $pageNumber = intval($queryVars[Constants::PAGE_NUMBER] ?? 1);

        $limit = Constants::POST_CONFIG_LIMIT;
        $start = ($pageNumber - 1) * $limit;

        $s = $queryVars['s'] ?? '';

        $countQuery =  "SELECT COUNT(ID)as total FROM ". $wpdb->posts ." WHERE post_type=%s  AND post_title LIKE '%s'";

        $totalCount = $wpdb->get_var($wpdb->prepare(
                                                $countQuery,
                                                Constants::IA_POST_CONFIG_POST_TYPE,
                                                "%". esc_sql($s) . "%"
                                            ));

        $fetchListQuery = "SELECT p1.*,
                            (
                                SELECT COUNT(p2.ID)
                                FROM ". $wpdb->posts ." AS p2
                                WHERE p2.post_status = '%s' AND p1.ID = p2.post_parent
                            ) as new_entries_count
                            FROM ". $wpdb->posts ." p1 
                            WHERE p1.post_type = '%s' 
                            AND p1.post_title LIKE '%s'
                              ORDER BY  new_entries_count DESC, p1.post_modified DESC LIMIT %d, %d
                           ";

        $list = $wpdb->get_results( $wpdb->prepare(
            $fetchListQuery,
            EntryStatus::STATUS_UNREAD,
            Constants::IA_POST_CONFIG_POST_TYPE,
            "%". esc_sql($s) . "%",
            $start,
            $limit
        ));

        $entries = [];

        $count = 0;
        foreach ($list as $k => $v) {
            $obj = $this->fromDb($v);
            $entries[] = $obj;
            $count++;
        }

        $numPages = ceil($totalCount / $limit);

        $result = $this->buildFetchListResult(
            $count,
            $totalCount,
            $numPages,
            $pageNumber,
            $entries,
            $entry
          );

        $this->getPostListFields($result);

        return $result;
    }

    public function fetchList($formConfigId, $entry = array(),  $queryVars = array())
    {
        if ($this->getPostType() == Constants::IA_POST_CONFIG_POST_TYPE) {
            return $this->fetchFormList($formConfigId, $entry, $queryVars);
        } else {
            $pageNumber = intval($queryVars[Constants::PAGE_NUMBER] ?? 1);

            $limit = Constants::POST_CONFIG_LIMIT;

            $s = $queryVars['s'] ?? '';

            $args = [
                'post_type' => $this->getPostType(),
                'orderby' => 'post_modified',
                'order' => 'DESC',
                'posts_per_page'   => $limit,
                'paged' => $pageNumber,
                's' => $s
            ];

            $result =  $this->doFetchList($formConfigId, $args, $entry);

            $this->getPostListFields($result);

            return $result;
        }
    }


    public function fetchListByPostType($postType, array $queryVars = array())
    {
        $start = intval($queryVars[Constants::START] ?? '0');
        $limit = intval($queryVars[Constants::LIMIT] ?? '0');

        if ($limit === 0) {
            $limit = Constants::POST_CONFIG_LIMIT;
        }

        $pageNumber  = intval($start / $limit) + 1;

        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'post_modified',
            'order' => 'DESC',
            'posts_per_page'   => $limit,
            'paged' => $pageNumber,
            'meta_query' =>  [
                [
                    'key'     => PostConfig::POST_CONFIG_TYPE,
                    'value'   => $postType,
                ]
            ]
        ];

        $result =  $this->doFetchList(0, $args);

        $this->getPostListFields($result);

        return $result;
    }

    public function fetchListByParentId($formConfigId, array $args)
    {
        $result =  $this->doFetchList($formConfigId, $args);

        $this->getPostListFields($result);

        return $result;
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0)
    {
        return PostConfig::POST_TYPE;
    }


    public function search($formConfigId, array $inArgs = array())
    {
        $s = $inArgs['s'] ?? '';
        $group_type = $inArgs['group_type'] ?? null;
        $subgroup_types = $inArgs['subgroup_types'] ?? null;

        $args = array(
            "post_type" => $this->getPostType(),
            'posts_per_page' => 50,
            'orderby' => 'post_title',
            'order' => 'ASC',
            "s" => $s
        );


        if (intval($group_type) != 0 || !empty($subgroup_types)) {
            $groupMetaQuery = intval($group_type) != 0 ? TemplateTypes::getMetaQueryByGroup(intval($group_type)) : array();

            $subGroupTypes = !empty($subgroup_types) ? explode(",", $subgroup_types) : array();

            $subgroupsMetaQuery = array();
            if (count($subGroupTypes) > 0) {
                $subgroupsMetaQuery['relation'] = 'OR';
                foreach ($subGroupTypes as $type) {
                    $subgroupsMetaQuery[] = array(
                        'key' => PostConfig::POST_CONFIG_TYPE,
                        'value' => $type
                    );
                }
            }

            $args = array_merge($args, [
                'meta_query' => array_merge($groupMetaQuery, $subgroupsMetaQuery)
            ]);
        }

        $query = get_posts($args);

        $entries = [];
        foreach ($query as $post) {
            $entries[] = $this->fromDb($post);
        }

        return $entries;
    }

    public function getByParentIdAndId($formConfigId, $id)
    {
        $models = ChoiceGroupModel::getInstance()->fetchModelsByFormConfig($id);

        $post = WPContentModel::doFindById($id);
        if ($post) {
            if ($post->post_type == $this->getPostType($formConfigId)) {
                $entry = $this->fromDb($post);

                $this->getPostFields($post->ID, $entry);

                $entry[PostConfig::MODELS] = $models;

                return $entry;
            }
        }

        return null;
    }
}
