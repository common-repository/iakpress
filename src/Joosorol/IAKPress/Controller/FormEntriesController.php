<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Joosorol\IAKPress\IAPost\BaseController;
use App\Joosorol\IAKPress\IAPost\PluginInterface;

use App\Joosorol\IAKPress\IAPost\ClientConfig;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\EntryModelMgr;
use App\Joosorol\IAKPress\IAService\MailService;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use App\Joosorol\IAKPress\Utils\FileUploader;
use App\Joosorol\WP\IAModel\EntryModel;

/**
 * Description of FormEntriesController
 *
 * @author bly
 */
class FormEntriesController extends BaseController {
    /**
     * @Route("/iakpress/posttype/{formConfigType}/config", name="client_config", methods={"HEAD","GET","OPTIONS"})
     */
    public function fetchClientConfig(Request $request,  $formConfigType) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }
        
        return new JsonResponse(ClientConfig::getInstance()->getAdminConfig($formConfigType));
    }



    /**
     * @Route("/iakpress/posttype/{formConfigType}/front-config", name="front_client_config", methods={"HEAD","GET","OPTIONS"})
     */
    public function fetchFrontClientConfig(Request $request,  $formConfigType) {
        return new JsonResponse(ClientConfig::getInstance()->getFrontConfig($formConfigType));
    }

    public function doFetchPostConfig($formConfigType, $id) {
        $formConfigMgr = $formConfigType == Constants::IA_POST_CONFIG_POST_TYPE ? 
                                                EntryModelMgr::getInstance()->postConfigModel() : 
                                                EntryModelMgr::getInstance()->choiceGroupModel();
        if (!is_null($formConfigMgr)) {
            $entry = $formConfigMgr->fetchSingle($id);
    
            return $entry;
        }

        return null;
    }

    /**
     * @Route("/iakpress/posttype/{formConfigType}/{id}/config", name="fetch_post_config", methods={"HEAD","GET","OPTIONS"})
     */
    public function fetchPostConfig(Request $request, $formConfigType, $id) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            $formType = intval(PostUtils::getInstance()->getPostMeta(intval($id), PostConfig::POST_CONFIG_TYPE, true));

            if (!$formType || !TemplateTypes::isGlobalForm($formType)) {
                return $this->accessDenied();
            }    
        }
    
        $entry = $this->doFetchPostConfig($formConfigType, $id);


        if (!is_null($entry)) {
            return new JsonResponse($entry);
        } else {
            return $this->notFound();
        }
    }
    

    /**
     * @Route("/iakpress/posttype/{formConfigType}/{id}/edit", name="edit_post_config", methods={"PUT","POST","OPTIONS"})
     */
    public function editPostConfig(Request $request, $formConfigType, $id) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $requestData = $request->request->all();

        $queryData = $request->query->all();

        $thePostType = $queryData['postType'] ?? $formConfigType;
        $theParentId = $queryData['formConfigId'] ?? 0;

        $formConfigMgr = EntryModelMgr::getInstance()->getModelByPostType($thePostType);
        if (is_null($formConfigMgr)) {
            return $this->notFound();
        }

        $result = $formConfigMgr->doEdit($theParentId, $id, $requestData);

        if (!is_null($result)) {
            return new JsonResponse([Constants::ENTRY => $result]);
        } else {
            return $this->notFound();
        }
    }

    /**
     * @Route("/iakpress/fieldtype/{fieldType}/model/{modelId}", name="fetch_datalist", methods={"HEAD","GET","OPTIONS"})
     */
    public function fetchDatalist(Request $request, $fieldType, $modelId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $queryVars = [
            Option::FIELD_TYPE => intval($fieldType)
        ];
    
        $result = EntryModelMgr::getInstance()->choiceGroupModel()->getAllDataListByGroupId(intval($modelId), $queryVars);


        if (!empty($result)) {
            $datalist = $result[Option::DATALIST] ?? $result[Option::DATALIST][$modelId] ?? array();
            return new JsonResponse($datalist[$modelId] ?? array());
        } else {
            return $this->notFound();
        }
    }


    /**
     * @Route("/iakpress/posttype/{formConfigType}/template/{templateId}/model/{modelId}/{formConfigId}", name="child_list", methods={"PUT","GET","OPTIONS"})
     */
    public function entryList(Request $request, $formConfigType, $templateId, $modelId, $formConfigId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId, $templateId);

        $queryVars = $request->query->all();

        $entryId = intval($queryVars[self::ENTRY_ID_KEY] ?? 0);

        $queryVars[Constants::MODEL_ID] = $modelId;
        $queryVars[Constants::POST_CONFIG_PARENT_ID] = $formConfigId;
        $queryVars[Constants::TEMPLATE_ID] = $templateId;

        if ($postMgr != null) {            
            $ret = $postMgr->fetchList($formConfigId, array(),  $queryVars);
 
            if ($entryId != 0) {
                $entry = $postMgr->getByPostypeAndId($formConfigType, $entryId, $formConfigId, $modelId);
                if (!is_null($entry)) {
                    $ret[Constants::ENTRY] = $entry;
                }
            }

            return new JsonResponse($ret);
        } else {
            return $this->notFound();
        }
    }

    /**
     * @Route("/iakpress/posttype/{formConfigType}/template/{templateId}/model/{modelId}/{formConfigId}/import", name="import_entries", methods={"PUT", "POST","OPTIONS"})
     */
    public function importEntries(Request $request, $formConfigType, $templateId, $modelId, $formConfigId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $all = $request->request->all();

        $values = $all[self::VALUES_KEY] ?? array();
        $csvData = $values[self::DATA_KEY] ?? array();

        $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId, $templateId);

        if ($postMgr != null) {
            foreach($csvData as $key => $requestData) {
                $requestData[Constants::MODEL_ID] = $modelId;
                $requestData[Constants::TEMPLATE_ID] = $templateId;
                $requestData[Constants::POST_CONFIG_PARENT_ID] = $formConfigId;
                
                $errors = array();
                $postMgr->doFastEdit($formConfigId, 0, $requestData, $errors);
            }

            $queryVars = $request->query->all();
            $queryVars[Constants::MODEL_ID] = $modelId;
            $queryVars[Constants::TEMPLATE_ID] = $templateId;

            if ($formConfigType == Constants::IA_POST_VIEW_POST_TYPE) {
                $entriesList = $postMgr->fetchList($modelId, array(),  $queryVars);
            } else {
                $entriesList = $postMgr->fetchList($formConfigId, array(),  $queryVars);
            }

            $formConfig = $this->doFetchPostConfig(Constants::IA_POST_CONFIG_POST_TYPE, $formConfigId);
            
            return new JsonResponse([
                self::POST_CONFIG => $formConfig,
                self::LIST_DATA => $entriesList
            ]);
        }
      
        return $this->notFound();
    }

    /**
     * @Route("/iakpress/posttype/{formConfigType}/template/{templateId}/model/{modelId}/{formConfigId}/massdel", name="delete_entries", methods={"PUT", "POST","OPTIONS"})
     */
    public function deleteEntries(Request $request, $formConfigType, $templateId, $modelId, $formConfigId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $all = $request->request->all();
        $values = $all[self::VALUES_KEY] ?? array();

        $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId, $templateId);
        if ($postMgr != null) {
            $queryVars = $request->query->all();
            $queryVars[Constants::MODEL_ID] = $modelId;
            $queryVars[Constants::TEMPLATE_ID] = $templateId;
            $postMgr->doMassDelete($formConfigId, $values, $queryVars);

            if ($formConfigType == Constants::IA_POST_VIEW_POST_TYPE) {
                $entriesList = $postMgr->fetchList($modelId, array(),  $queryVars);
            } else {
                $entriesList = $postMgr->fetchList($formConfigId, array(),  $queryVars);
            }

            $formConfig = $this->doFetchPostConfig(Constants::IA_POST_CONFIG_POST_TYPE, $formConfigId);
            
            return new JsonResponse([
                self::POST_CONFIG => $formConfig,
                self::LIST_DATA => $entriesList
            ]);
        } else {
            return $this->notFound();
        }
    }


    
    /**
     * @Route("/iakpress/posttype/{formConfigType}/template/{templateId}/model/{modelId}/{formConfigId}/{entryId}/edit", name="model_entry_edit", methods={"PUT","POST","OPTIONS"})
     */
    public function entryEdit(Request $request, $formConfigType, $templateId, $modelId, $formConfigId, $entryId) {
        $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId, $templateId);

        if ($postMgr != null) {
            $requestData = $request->request->all();

            // upload files if any
            FileUploader::upload($requestData);

            if (intval($modelId) != 0) {
                if (!isset($requestData[Constants::MODEL_ID])) {
                    $requestData[Constants::MODEL_ID] = $modelId;
                }
            } else {
                $requestData[Constants::MODEL_ID] = $formConfigId;
            }

            $requestData[Constants::TEMPLATE_ID] = $templateId;

            $requestData[Constants::POST_CONFIG_PARENT_ID] = $formConfigId;

            $submitBtnType = intval($requestData[Constants::SUBMIT_BTN_TYPE] ?? FieldRenderType::FORM_BTN_SUBMIT_TYPE);
            $submitBtnName = $requestData[Constants::SUBMIT_BTN_NAME] ?? '';

            // unset SUBMIT_BTN_TYPE
            unset($requestData[Constants::SUBMIT_BTN_TYPE]);
            // unset SUBMIT_BTN_NAME
            unset($requestData[Constants::SUBMIT_BTN_NAME]);
             // unset SUBMIT_BTN_STEP
             unset($requestData[Constants::SUBMIT_BTN_STEP]);

            if ($submitBtnType == FieldRenderType::FORM_BTN_SUBMIT_TYPE) {
                $item = $postMgr->doEdit($formConfigId, $entryId, $requestData);
            } else { // set item to requestData
                $item =  $requestData;
                if (!isset($requestData[Constants::ID])) {
                    $item[Constants::ID] = Constants::DEFAULT_ID_VALUE;
                }
            }

            // set submit_btn_type for front end handling
            $item[Constants::SUBMIT_BTN_TYPE] = $submitBtnType;
            $item[Constants::SUBMIT_BTN_NAME] = $submitBtnName;

            if (isset($item[Constants::ENTRY])) {
                $item[Constants::ENTRY][Constants::SUBMIT_BTN_TYPE] = $submitBtnType;
                $item[Constants::ENTRY][Constants::SUBMIT_BTN_NAME] = $submitBtnName;
            }

            $hasErrors = isset($item[Constants::RESPONSE_ERRORS]) ? true : false;

            if (TemplateTypes::isForm($templateId) 
                && $formConfigType != Constants::IA_GENERIC_MODEL_POST_TYPE
                && !$hasErrors) { // form entry edit
                $item = MailService::getInstance()->handleFormActions($formConfigId, $entryId, $item, $submitBtnType, $submitBtnName);
            }
            
            if ($hasErrors) { // entry creation has errors : entry not created
                return new JsonResponse($item);
            } else if (PluginInterface::getInstance()->getUserCanManage()) { // model entry edit
                $queryVars = $request->query->all();

                $queryVars[Constants::MODEL_ID] = $modelId;
                $queryVars[Constants::POST_CONFIG_PARENT_ID] = $formConfigId;
                $queryVars[Constants::TEMPLATE_ID] = $templateId;
                if (isset($requestData[Constants::PNODE_ID])) {
                    $queryVars[Constants::PNODE_ID] = $requestData[Constants::PNODE_ID];
                }
   
                $entriesList = $postMgr->fetchList($modelId, $item,  $queryVars);

                // update current entry
                $entriesList[Constants::ENTRY] = $item;

                $formConfig = $this->doFetchPostConfig(Constants::IA_POST_CONFIG_POST_TYPE, $formConfigId);
            
                $response = array_merge(
                    $item,
                    [
                    self::POST_CONFIG => $formConfig,
                    self::LIST_DATA => $entriesList
                    ]
                );
            } else {
                $response = array_merge(
                    $item,
                    [
                        self::LIST_DATA => [Constants::ENTRY => $item]
                    ]
                );
            }

            return new JsonResponse($response);
        } else {
            return $this->notFound();
        }
    }

     /**
     * @Route("/iakpress/posttype/{formConfigType}/template/{templateId}/model/{modelId}/{formConfigId}/{entryId}/delete", name="model_entry_delete", methods={"PUT","POST","OPTIONS"})
     */
    public function entryDelete(Request $request, $formConfigType, $templateId, $modelId, $formConfigId, $entryId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }
  
        $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId, $templateId);
        if ($postMgr != null) {
            $queryVars = $request->query->all();
            $queryVars[Constants::MODEL_ID] = $modelId;
            $queryVars[Constants::TEMPLATE_ID] = $templateId;

            $entriesList = $postMgr->delete($formConfigId, $entryId, $queryVars);


            $formConfig = $this->doFetchPostConfig(Constants::IA_POST_CONFIG_POST_TYPE, $formConfigId);
            
            return new JsonResponse([
                self::POST_CONFIG => $formConfig,
                self::LIST_DATA => $entriesList
            ]);            
        } else {
            return $this->notFound();
        }
    }

    
     /**
     * @Route("/iakpress/posttype/{formConfigType}/template/{templateId}/model/{modelId}/{formConfigId}/{entryId}/view", name="model_entry_view", methods={"HEAD","GET","OPTIONS"})
     */
    public function entryView(Request $request, $formConfigType, $templateId, $modelId, $formConfigId, $entryId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }
  
        $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId, $templateId);
        if ($postMgr != null) {
            $entry = $postMgr->getByPostypeAndId($formConfigType, $entryId, $formConfigId, $modelId);
            return new JsonResponse($entry);            
        } else {
            return $this->notFound();
        }
    }


     /**
     * @Route("/iakpress/posttype/{formConfigType}/{id}/delete", name="delete_post", methods={"PUT","POST","OPTIONS"})
     */
    public function deletePost(Request $request, $formConfigType, $id) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $formConfigMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType);
        if (is_null($formConfigMgr)) {
            return $this->notFound();
        }

        EntryModelMgr::getInstance()->fieldModel()->deleteFields($id);

        $queryVars = $request->query->all();

        $result = $formConfigMgr->delete(0, $id,  $queryVars);
  
        return new JsonResponse($result);
    }

    /**
     * @Route("/iakpress/posttype/{formConfigType}/{id}/publish", name="publish_post", methods={"PUT","POST","OPTIONS"})
     */
    public function publishPost(Request $request, $formConfigType, $id) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $formConfigMgr = EntryModelMgr::getInstance()->postConfigModel();
        if (is_null($formConfigMgr)) {
            return $this->notFound();
        }

        $values =  $request->request->all()[self::VALUES_KEY] ?? array();
        $entry = $formConfigMgr->publish($id, $values);

        if (!is_null($entry)) {
            return new JsonResponse($entry);
        } else {
            return $this->notFound();
        }
    }

     /**
     * @Route("/iakpress/posttype/{formConfigType}/{id}/unpublish", name="unpublish_post", methods={"PUT","POST","OPTIONS"})
     */
    public function unpublishPost(Request $request, $formConfigType, $id) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $formConfigMgr =EntryModelMgr::getInstance()->postConfigModel();
        if (is_null($formConfigMgr)) {
            return $this->notFound();
        }

        $values =  $request->request->all()[self::VALUES_KEY] ?? array();
        $entry = $formConfigMgr->unpublish($id, $values);

        if (!is_null($entry)) {
            return new JsonResponse($entry);
        } else {
            return $this->notFound();
        }
    }


    /**
     * @Route("/iakpress/posttype/{formConfigType}/{id}/fields", name="edit_post_fields", methods={"PUT","POST","OPTIONS"})
     */
    public function editPostFields(Request $request, $formConfigType, $id) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $requestData = $request->request->all();

        $entryId2InternalIdMap = array();

        $formConfigMgr = EntryModelMgr::getInstance()->postConfigModel();
        if (is_null($formConfigMgr)) {
            return $this->notFound();
        }

        $fieldModel = EntryModelMgr::getInstance()->fieldModel();
        if (is_null($fieldModel)) {
            return $this->notFound();
        }

        $postFields = $fieldModel->saveFields($requestData, $id, $entryId2InternalIdMap);
                
        $result = $formConfigMgr->updatePostConfig($requestData, $postFields, $entryId2InternalIdMap);
        
        return new JsonResponse($result);
    }


     /**
     * @Route("/iakpress/posttype/{formConfigType}", name="form_post_list", methods={"HEAD","GET","OPTIONS"})
     */
    public function fetchPostList(Request $request, $formConfigType) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $formConfigMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType);

        if (is_null($formConfigMgr)) {
            return $this->notFound();
        }

        $queryVars = $request->query->all();
        $entryId = intval($queryVars[self::ENTRY_ID_KEY] ?? 0);

        $list = $formConfigMgr->fetchList(0, array(), $request->query->all());

        if (!is_null($list) && $entryId != 0) {
            $entry = $this->doFetchPostConfig($formConfigType, $entryId);
            if (!is_null($entry)) {
                $list[Constants::ENTRY] = $entry;
            }
        }
  
        return new JsonResponse($list);
    }

  
    /**
     * @Route("/iakpress/posttype/{formConfigType}/{formConfigId}", name="search_posts", methods={"HEAD","GET","OPTIONS"})
     */
    public function searchPosts(Request $request, $formConfigType, $formConfigId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        if (intval($formConfigId) != 0) {
            $queryVars = $request->query->all();
            $queryVars[Constants::MODEL_ID] = $formConfigId;

            $entryModel = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId);

            if ($entryModel != null) {
                $res = $entryModel->search($formConfigId, $queryVars);
                return new JsonResponse($res);
            }
        } else {
            $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType);

            if ($postMgr != null) {
                $res = $postMgr->search(0, $request->query->all());
                return new JsonResponse($res); 
            }
        }

        return $this->notFound();
    }

    /**
     * @Route("/iakpress/posttype/{formConfigType}/{formConfigId}/entry/{entryId}", name="fetch_post", methods={"HEAD","GET","OPTIONS"})
     */
    public function fetchPost(Request $request, $formConfigType, $formConfigId, $entryId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }
        
        if (intval($formConfigId) != 0) {
            if (!PluginInterface::getInstance()->getUserCanManage()) {
                return $this->accessDenied();
            }
    
            $entryModel = EntryModelMgr::getInstance()->getModelByPostType($formConfigType, $formConfigId);
            if ($entryModel != null) {
                $res = $entryModel->getByParentIdAndId($formConfigId, $entryId);
                return new JsonResponse($res);
            }
        } else {
            $postMgr = EntryModelMgr::getInstance()->getModelByPostType($formConfigType);

            if ($postMgr != null) {
                $res = $postMgr->getByParentIdAndId($formConfigId, $entryId);
                return new JsonResponse($res);
            }
        }

        return $this->notFound();
    }
}
