<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license informConfigation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;

use App\Joosorol\IAKPress\IAModel\EntryModelMgr;
use App\Joosorol\IAKPress\IAModel\FieldConfigModelInterface;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\PostData;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

use App\Joosorol\IAKPress\IAPost\PostFields;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;

use App\Joosorol\IAKPress\IAPost\PostRequestData;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IATemplate\CustomList;
use App\Joosorol\IAKPress\IAPost\IATemplate\IASection\SectionUtils;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleListWithImages;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleList;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleProductList;
use App\Joosorol\IAKPress\IAPost\IATemplate\ProductList;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;

class FieldConfigModel extends EntryModel implements FieldConfigModelInterface
{
    const CHOICE_LIST = 'choice_list';
    const CHOICEGROUP_LIST = 'choicegroup_list';
    const CHOICE_TOPLIST = 'choice_toplist';

    const FIRST_TWENTY_CHARS_LEN = 42;

    /**
     * @var FieldConfigModel The single instance of the class
     */
    private static $sInstance = null;

    var $currentPostConfigId = 0;

    /**
     * FieldConfigModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main FieldConfigModel Instance
     *
     * Ensures only one instance of FieldConfigModel is loaded or can be loaded.
     *
     * @static
     * @return FieldConfigModel - Main instance
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

        $formData->setPostType($this->getPostType($formConfigId));
        $formData->setPostParent(intval($formConfigId));
        $formData->setPostTitle(trim($values[Option::LABEL] ?? ''));

        $formData->setPostContent($values[SubPostType::CONTENT] ?? '');

        // set Name only when field does not created yet
        $id = intval($values[SubPostType::ID] ?? '0');
        $name = trim($values[SubPostType::NAME] ?? '');
        if (!empty($name) && $id == 0) {
            $name = strtolower($name);
            $modifiedName = $name;
            $index = 1;
            while ( $this->getIdByParentIdAndName($formConfigId, $modifiedName) != 0 ) {
              $modifiedName = sprintf("%s%s", $name, $index); 
              $index++;
            }
            $formData->setPostName($modifiedName);
        }

        $formData->setMenuOrder(trim($values[SubPostType::MENU_ORDER] ?? ''));

        unset($values[SubPostType::ID]);

        if (!isset($values[Option::SHORT_NAME])) {
            $values[Option::SHORT_NAME] = $name;
        }

        unset($values[SubPostType::NAME]);
        
        unset($values[SubPostType::CONTENT]);
        unset($values[SubPostType::INTERNAL_ID]);

        unset($values[Option::LABEL]);
        unset($values[SubPostType::POST_CONFIG_PARENT_ID]);
        unset($values[SubPostType::INTRO]);
        unset($values[SubPostType::USER_ID]);
        unset($values[Option::CONTENT_BODY]);
        unset($values[Option::DATALIST]);

        $fieldType = intval($values[Option::FIELD_TYPE] ?? '0');
        $parentTplId = FieldRenderType::getParentTypeId($fieldType);
        // should not show label on content field
        if ($parentTplId == FieldRenderType::SELECT_CONTENT_TYPE &&
            $fieldType != FieldRenderType::CONTENT_INPUT_PARAGRAPH) {
            $values[Option::HIDE_LABEL] = 'true';
        }

        $formData->setMetaValues($values);

        if (strlen($formData->getPostTitle()) < 2) {
            $formData->setIsValid(false);
            return $formData;
        }

        $formData->setIsValid(true);
        return $formData;
    }



    public function fromDb($post, $formConfigId = 0,  $modelId = 0): array
    {
        // get meta values
        $meta = array();
        $tab = $this->getPostMeta($post->ID, '', true);
        foreach ($tab as $fieldName=> $fieldValues) {
            if (!empty($fieldValues)) {
                if ($fieldName != SubPostType::EDIT_LOCK && $fieldName !=  SubPostType::EDIT_LAST) {
                    $fieldVal = $fieldValues[0];
                    if ($fieldName == Option::PASSWORD) {
                        $decryptedPassword =
                            PostUtils::getInstance()->decrypt($fieldVal);
                                
                        $meta[$fieldName] =  $decryptedPassword;
                    } else {
                        $meta[$fieldName] =  $fieldVal;
                    }
                }
            }
        }

        $fieldType = intval($meta[Option::FIELD_TYPE] ?? '0');

        $modelId = intval($meta[Option::MODEL_ID] ?? 0);
        
        $datalist = $modelId != 0 ? ChoiceGroupModel::getInstance()->getAllDataListByGroupId($modelId, $meta) : array();
        
        // when short_name is not empty then use it as the field name
        // else use name
        $shortName = $meta[Option::SHORT_NAME] ?? '';
        $name = !empty($shortName) ? $shortName : $post->post_name;

        return array_merge(
            [
                SubPostType::ID => $post->ID,
                SubPostType::POST_CONFIG_PARENT_ID => $post->post_parent,
                Option::LABEL => html_entity_decode($post->post_title),
                SubPostType::NAME => $name,
                SubPostType::CONTENT => $post->post_content,
                SubPostType::MENU_ORDER => $post->menu_order,
                SubPostType::UPDATED_AT => $post->post_modified,
                SubPostType::UPDATED_AT_GMT => $post->post_modified_gmt
            ],

            $meta,

            $datalist
        );
    }

    public function hasDataList(int $fieldType) : bool {
        $parentFieldType = FieldRenderType::getParentTypeId($fieldType);

        return $fieldType == FieldRenderType::DISPLAY_BLOCK_CONTENT_SLIDER 
                            || $parentFieldType == FieldRenderType::SELECT_CHOICE_TYPE;
    }

    public function getModelType(int $fieldType, array $requestData = array()) : int {
        if ($this->hasDataList($fieldType)) {
            if (isset($requestData[Option::MODEL_TYPE])) {
                return $requestData[Option::MODEL_TYPE];
            }
    
            switch ($fieldType) {
                case FieldRenderType::CHOICE_IMAGE_LIST:
                    return SimpleListWithImages::TYPE_VALUE;

                case FieldRenderType::CHOICE_PRODUCT_LIST;
                    return ProductList::TYPE_VALUE;
                
                case FieldRenderType::CHOICE_CUSTOM_LIST:
                    return CustomList::TYPE_VALUE;
            
                case FieldRenderType::DISPLAY_BLOCK_CONTENT_SLIDER:
                    return SimpleProductList::TYPE_VALUE;
    
                default:
                    return SimpleList::TYPE_VALUE;
            }
        }

        return 0;
    }

    public function doAddAndUpdateMeta($formConfigId, array $requestData) {
        $formData = $this->toDb($requestData, $formConfigId);
        $formData->setId(0);

        $errors = array();
        $post = $this->doCreateOrUpdate($formConfigId, $formData, $errors);

        $meta = $formData->getMetaValues();

        if (!is_null($post)) {
            $meta = $formData->getMetaValues();

            $fieldType = intval($meta[Option::FIELD_TYPE] ?? 0);

            if ($fieldType == FieldRenderType::CHOICE_IMAGE_LIST ||
                $fieldType == FieldRenderType::DISPLAY_BLOCK_CONTENT_SLIDER) {
                $modelType = $this->getModelType($fieldType);
                if ($modelType != 0) {
                    $meta[Option::MODEL_TYPE] = $modelType;
    
                    $datalist = $this->tryCreateDatalist($formConfigId, $post, $meta);
                    if (!is_null($datalist)) {
                        $meta[Option::MODEL_ID] = $datalist->ID;
                    }
                }
            }

            // add section subfields if any
            $this->onSectionCreated($formConfigId, $post, $requestData);

            // set field meta
            $metaRows = array();
            $this->updateOrGetMetaRows($formConfigId, 0, $post, $meta, $metaRows, false);
        }

        return $post;
    }

    public function doFastEdit($formConfigId, $entryId, array $requestData, array &$errors)
    {
        $formData = $this->toDb($requestData, $formConfigId);
        $formData->setId(intval($entryId));

        $post = $this->doCreateOrUpdate($formConfigId, $formData, $requestData);

        if (!is_null($post)) {
            $meta = $formData->getMetaValues();

            // set short name
            if (!isset($requestData[Option::SHORT_NAME]) || empty($requestData[Option::SHORT_NAME])) {
                $shortName = $post->post_name;
            } else {
                $shortName = $requestData[Option::SHORT_NAME];
            }

            $shortName = str_replace("-", "_", $shortName);
            $meta[Option::SHORT_NAME] = $shortName;

            $fieldType = intval($meta[Option::FIELD_TYPE] ?? 0);

            $oldMeta = $this->getPostMeta($post->ID, '', true);
   
            // remove obsolete options
            $theEntryId = intval($entryId);
            if ($theEntryId != 0) {
                foreach ($oldMeta as $fieldName=> $oldFieldValues) {
                    if ($fieldName != Option::PASSWORD) {
                        if (!empty($oldFieldValues)) {
                            $oldFieldVal = $oldFieldValues[0];
        
                            if (!isset($meta[$fieldName])) {
                                $this->deletePostMeta($post->ID, $fieldName);
                            } else if ($oldFieldVal == $meta[$fieldName]) { // value not changed ==> no need to update
                                unset($meta[$fieldName]);
                            }
                        }    
                    }               
                }    
            }

            $datalist = $theEntryId == 0  && $this->hasDataList($fieldType)
                                        ? $this->tryCreateDatalist($formConfigId, $post, $meta) : null;
            if (!is_null($datalist)) {
                $meta[Option::MODEL_ID] = $datalist->ID;
            }
           
            // add section subfields if any
            $this->onSectionCreated($formConfigId, $post, $requestData);

            // set field meta
            $metaRows = array();
            $this->updateOrGetMetaRows($formConfigId, $entryId, $post, $meta, $metaRows);
        }

        return $post;
    }

     /**
     * Called each time a fieldConfig is created
     */
    protected function tryCreateDatalist($formConfigId, $post, array $requestData) 
    {
        $fieldType = intval($requestData[Option::FIELD_TYPE] ?? 0);
        if (FieldRenderType::isBasicChoiceType($fieldType)) {
            $modelType = $this->getModelType($fieldType, $requestData);

            if ($modelType != 0) {
                $errors = array();
    
                return ChoiceGroupModel::getInstance()->doFastEdit(
                    0,
                    0, 
                    [
                        Option::TITLE => $post->post_title,
                        Option::TYPE => $modelType,
                        Constants::MODEL_ID => 0,
                        Constants::TEMPLATE_ID => 0,
                        Option::PARENT_ID => 0
                    ],
                    $errors
                );
            }
        }
       
        return null;
    }

    /**
     * Called each time a section field is created
     */
    protected function onSectionCreated($formConfigId, $post, array $requestData) 
    {
        $fieldType = intval($requestData[Option::FIELD_TYPE] ?? 0);

        if (FieldRenderType::isSection($fieldType)) {
            $sectionName = $requestData[Option::SHORT_NAME] ?? $post->name;
            $sectionFields = SectionUtils::getDefaultFields($sectionName, $fieldType);

            foreach($sectionFields as $fieldValues) {
                $errors = array();
                $this->doFastEdit($formConfigId, 0, $fieldValues, $errors);
            }
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
        $formData = $this->toDb($requestData, $formConfigId);
        $formData->setId(intval($entryId));

        $errors = array();
        $post = $this->doFastEdit($formConfigId, $entryId, $requestData, $errors);

        if (!is_null($post)) {
            return $this->fromDb($post, $formConfigId);
        } else {
            return array();
        }
    }


    public function updateOrGetMetaRows($formConfigId, $oldEntryId, $post, array $meta, array &$metaRows, $get = false) {
        // set new options values
        $fieldType = intval($meta[Option::FIELD_TYPE]  ?? 0);
        $parentFieldType = FieldRenderType::getParentTypeId($fieldType);

        foreach ($meta as $fieldName => $fieldVal) {                
            if (!is_array($fieldVal)) {

                if ($fieldType == FieldRenderType::BF_TEXTAREA_TYPE
                    || $fieldName == Option::LABEL_STYLE 
                    || $fieldName == Option::INPUT_STYLE) {
                    if ($get) {
                        $metaRows[] = sprintf("('%s', '%s', '%s')", $post->ID, $fieldName, wp_kses_post($fieldVal));
                    } else { 
                        $this->updatePostMeta($post->ID, $fieldName, wp_kses_post($fieldVal));
                    }  
                } else {
                    if ($fieldName == Option::PASSWORD) {

                        $cryptedPassword =
                            PostUtils::getInstance()->encrypt($fieldVal);

             
                        if ($get) {
                            $metaRows[] = sprintf("('%s', '%s', '%s')", $post->ID, $fieldName, $cryptedPassword);
                        } else {
                            $this->updatePostMeta($post->ID, $fieldName, $cryptedPassword);
                        }  
                    } else {
                        if ($get) {
                            $metaRows[] = sprintf("('%s', '%s', '%s')", $post->ID, $fieldName, sanitize_text_field($fieldVal));
                        } else {
                            $this->updatePostMeta($post->ID, $fieldName, sanitize_text_field($fieldVal));
                        }  
                    }
                }
            } else {
                if ($parentFieldType != FieldRenderType::SELECT_API_CONFIG_TYPE) {
                    $newFieldVal = implode(",", $fieldVal);

                    if ($get) {
                        $metaRows[] = sprintf("('%s', '%s', '%s')", $post->ID, $fieldName, sanitize_text_field($newFieldVal));
                    } else {
                        $this->updatePostMeta($post->ID, $fieldName, sanitize_text_field($newFieldVal));
                    }  
                }
            }
        }
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        return Constants::IA_FIELD_POST_TYPE;
    }

      /**
     * Delete formConfig fields
     * @param $formConfigId
     * @return 
     */
    public function deleteFields($formConfigId) {
        $args = array( 
            'post_parent' => $formConfigId,
            'post_type' => $this->getPostType($formConfigId)
        );
        
        $postList =  get_children( $args );
        foreach ($postList as $k => $post) {
            $this->delete($formConfigId, $post->ID);
        }
    }


    /**
     * Do Delete entry
     * @param integer $entryId
     * @return
     */
    public function doDelete($formConfigId, $entryId, $queryVars = array())
    {
        $oldEntry = $this->getById($entryId);


        // delete linked datalist
        $choiceGroupModel = EntryModelMgr::getInstance()->choiceGroupModel();
        $datalist = $oldEntry[Option::DATALIST] ?? array();
        foreach ($datalist as $listId => $listConfig) {
            $subFields =  $listConfig[PostConfig::FIELDS] ?? array();
            foreach($subFields as $subFieldName => $subFieldConfig) {
                $subDatalist = $subFieldConfig[Option::DATALIST] ?? array();
                foreach ($subDatalist as $subListId => $subListConfig) {
                    $this->deleteFields($subListId);
                    $choiceGroupModel->delete(0, $subListId);
                }
            }

            $this->deleteFields($listId);
            $choiceGroupModel->delete(0, $listId);
        }

        // delete this field

        $this->deletePost($formConfigId, $entryId, true);

        return $oldEntry;
    }

    /**
     * Get saved formConfig fields
     * @param $formConfigId
     * @return 
     */
    public function getSavedFields($formConfigId) {
        $args = array( 
            'post_parent' => $formConfigId,
            'post_type' => $this->getPostType($formConfigId)
        );
        
        $savedFields = array();
        $postList =  get_children( $args );
        foreach ($postList as $k => $post) {
            $savedFields[$post->ID] = $post;
        }

        return $savedFields;
    }

     /**
     * Save formConfig fields
     * @param array $requestData
     * @param $formConfigId
     * @return 
     */
    public function saveFields(array $requestData, $formConfigId, array &$entryId2InternalIdMap)
    {
        $values = $requestData['values'];
      
        $formConfigSettings = $values[PostFields::POST_CONFIG_CONFIG_KEY];
        $type = $formConfigSettings[Option::POST_CONFIG_TYPE];
        

        unset($formConfigSettings[Option::POST_CONFIG_TYPE]);
        
        $PostFields = new PostFields($type, $formConfigSettings);

        $formConfigRequestData = new PostRequestData($values);
        
        $orderNum = 0;
        foreach ($formConfigRequestData->getPostOrderList() as $order) {
            $internalId = $order[PostRequestData::INTERNAL_ID_KEY];
            $fieldAttrs = $formConfigRequestData->getPostValueMap()[$internalId];
            
            $fieldAttrs[SubPostType::MENU_ORDER] = $orderNum;
            $entryId = intval($fieldAttrs[PostFields::FIELD_ID] ?? '0');
            $entry = $this->doEdit($formConfigId, $entryId, $fieldAttrs);

            if (!empty($entry)) {
                $entryId2InternalIdMap[$entry[SubPostType::ID]] = $internalId;
            }

            $orderNum++;
        }

        return $PostFields->toArray();
    }

    public function getChoiceList($fieldId) : array {
        $res = GenericEntryModel::getInstance()->fetchList($fieldId);
        $entries = $res[Constants::ENTRIES] ?? array();

        return [
            self::CHOICE_LIST =>  $entries
        ];
    }

    public function getChoiceGroupList($fieldId) : array {
        $res = ChoiceGroupModel::getInstance()->fetchList($fieldId);
        $entries = $res[Constants::ENTRIES] ?? array();

        return [
            self::CHOICEGROUP_LIST => $entries
        ];
    }

    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $args = array( 
            'post_parent' => $formConfigId,
            'post_type' => $this->getPostType($formConfigId),
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page'   => -1
        );

        return $this->doFetchList($formConfigId, $args, $entry);
    }

    public function getListByName($formConfigId)
    {
        $args = array( 
            'post_parent' => $formConfigId,
            'post_type' => $this->getPostType($formConfigId),
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page'   => -1
        );

        $query = new \WP_Query($args);
    
        $entries = [];
    
        while ($query->have_posts()) {
          $post = $query->next_post();
    
          $field = $this->fromDb($post, $formConfigId);
          $entries[$field[Option::NAME]] = $field; 
        }
    
        return $entries;
    }


    public function fetchMailNotifActions($formConfigId)
    {
        $args = [
            'post_type' => $this->getPostType($formConfigId),
            'post_parent' => $formConfigId,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page'   => -1
        ];

       
        $args['meta_query'] =  [
            [
                'key'     => Option::FIELD_TYPE,
                'value'   => FieldRenderType::ACTION_MAIL_NOTIFICATION_TYPE,
            ]
        ];


        $query = new \WP_Query($args);    
        $entries = [];
    
        while ($query->have_posts()) {
            $post = $query->next_post();
    
            $entry = $this->fromDb($post, $formConfigId);
            $entries[$entry[Option::NAME]] = array_merge($entry, [
                SubPostType::CONTENT => $post->post_content,
                Option::API_CONFIG => ApiKeysModel::getInstance()->fetchSingle($entry[Option::API_ID] ?? '0'),
            ]);
        }
    

        return $entries;
    }

    public function fetchFrontActions($formConfigId)
    {
        $args = [
            'post_type' => $this->getPostType($formConfigId),
            'post_parent' => $formConfigId,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page'   => -1
        ];

       
        $args['meta_query'] =  [
            'relation' => 'OR',
            [
                'key'     => Option::FIELD_TYPE,
                'value'   => FieldRenderType::ACTION_THANK_YOU_SCREEN_TYPE,
            ]
        ];


        $query = new \WP_Query($args);
    
        $entries = [];
    
        while ($query->have_posts()) {
          $post = $query->next_post();

          $entry = $this->fromDb($post, $formConfigId);
          $entries[$entry[Option::NAME]] = array_merge($entry, [
            SubPostType::CONTENT => $post->post_content
          ]);
        }
    
        return $entries;
    }

    public function getDatalist(array $fields, array $fieldConfig) : array {
        $res = array();

        $modelId = intval($fieldConfig[Option::MODEL_ID] ?? 0);
        $fieldType = intval($fieldConfig[Option::FIELD_TYPE] ?? 0);

        if (FieldRenderType::isBasicChoiceType($fieldType)) {
            $datalist = $fieldConfig[Option::DATALIST] ?? array();

            $res = $datalist[$modelId] ?? array();
        } else {
            $parentFieldType = $fieldType;

            $parentField =  $fieldConfig[Option::PARENT_FIELD] ?? '';

            $parentFieldConfig = array();

            while (FieldRenderType::isCascadingChoiceType($parentFieldType)) {    
                $parentFieldConfig = $fields[$parentField] ?? array();

                $parentFieldType = intval($parentFieldConfig[Option::FIELD_TYPE] ?? 0);
                $parentField = $parentFieldConfig[Option::PARENT_FIELD] ?? '';   
            }

            $datalist = $parentFieldConfig[Option::DATALIST] ?? array();
            $modelId = $parentFieldConfig[Option::MODEL_ID] ?? 0;

            $res = $datalist[$modelId] ?? array();
        }

        return $res;
    }
}
