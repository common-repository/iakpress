<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use Exception;

/**
 * Description of PluginInterfaceBase
 *
 * @author bly
 */
class PluginInterfaceBase {
    const PLUGIN_ATTRIBUTES = 'plugin_attributes';
    const PLUGIN_PREFIX = 'plugin_prefix';
    const PLUGIN_URL = 'plugin_url';
    const TIMEZONE = 'timezone';
    const IS_DEV_ENV = 'is_dev_env';
    const ENABLE_DEBUG = 'enable_debug';
    const SITE_URL = 'site_url';
    const ADMIN_AJAX_URL = 'admin_ajax_url';
    const AJAX_URL = 'ajax_url';
    const ADMIN_HOME_URL = 'admin_home_url';
    const STATIC_URL = 'static_url';
    const ADMIN_POST_URL = 'admin_post_url';
    const LICENCE_GET_URL = 'licence_get_url';
    const PATH_INFO = 'path_info';
    const SITE_NAME = 'site_name';
    const SITE_DESC = 'site_desc';
    const ADMIN_EMAIL = 'admin_email';
    const UPLOAD_BASEDIR = 'upload_basedir';
    const REQUEST_TYPE = 'request_type';
    const IS_INTERNAL_REQUEST = 'is_internal_request';
    const POST_TYPE = 'post_type';
    const ACCESS_DENIED_ERR = 'Access Denied. You do not have permission to access this page.';
    const PAGE = 'page';

    const DELIMITER = "_";

    /**
     * @var array
     */
    private $attrs;
        
    private $assets;

    private $tablePrefix = '';
    
    /**
     *
     * @var Twig_Environment 
     */
    private $twig = null;


    /**
     *
     * @var array
     * admin admin forms mapped by postType
     */
    private $formAdminList;



    private $pluginDir  = "";

    private $customPostTypes =  array();

    /**
     * Constructor
     */
    protected function __construct() {
        $this->formAdminList = array();
       
        $this->assets = array();
   
        $this->attrs = array();
        $this->attrs[self::PLUGIN_PREFIX] = '';
        $this->attrs[self::PLUGIN_URL] = '';
        $this->attrs[self::TIMEZONE] = '';
        $this->attrs[self::IS_DEV_ENV] = false;
        $this->attrs[self::ENABLE_DEBUG] = false;
        $this->attrs[self::SITE_URL] = '';
        $this->attrs[self::ADMIN_AJAX_URL] = '';
        $this->attrs[self::AJAX_URL] = '';
        $this->attrs[self::ADMIN_HOME_URL] = '';
        $this->attrs[self::STATIC_URL] = '';
        $this->attrs[self::ADMIN_POST_URL] = '';
        $this->attrs[self::PATH_INFO] = '';
        $this->attrs[self::SITE_NAME] = '';
        $this->attrs[self::SITE_DESC] = '';
        $this->attrs[self::ADMIN_EMAIL] = '';
        $this->attrs[self::UPLOAD_BASEDIR] = '';
        $this->attrs[self::REQUEST_TYPE] = '';
        $this->attrs[self::IS_INTERNAL_REQUEST] = false;
        $this->attrs[self::POST_TYPE] = '';
        $this->attrs[self::PAGE] = '';
        $this->attrs[self::LICENCE_GET_URL] = '';
    }

    public final function addPostAdmin(AbstractPostAdmin $formAdmin) {
        $this->formAdminList[$formAdmin->getName()] = $formAdmin;
    }

    /**
     * Get form admins mapped by postType
     * @return array $this->formAdminList
     */
    public final function getPostAdminList(): array {
        return $this->formAdminList;
    }

    public final function getPostAdminByPostType($postType) {
        $formAdmin = $this->formAdminList[$postType] ?? null;
        return $formAdmin;
    }

    public function getTwig(): \Twig\Environment {
        if (is_null( $this->twig)) {
            // the path to application twig templates
            $viewsDir = realpath($this->pluginDir . '/public/');

            $this->twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(array($viewsDir,)));

            $this->twig->addExtension(new \Twig\Extension\StringLoaderExtension());
        }
       
  
        return $this->twig;
    }

    public function getIsProVersion() {
        $proStaticUrl = PostUtils::getInstance()->getOption(Constants::PRO_STATIC_URL);

        if (empty($proStaticUrl)) {
            return false;
        } else {
            return true;
        }
    }

    public function getIsProVersionStr() {
        return $this->getIsProVersion() ? "true" : "false";
    }

    public function buildAssetUrl($file) {                    
        return $this->getStaticUrl() .'/'. $file;
    }

    public function getPluginIconUrl() {
        return $this->buildAssetUrl('css/images/iakpress/avatar09.jpg');
    }

    public function getAssets() {
        return $this->assets;
    }

    public function setAssets($assets) {
        $this->assets = $assets;
    }

    public function addCustomPostType($formConfig) {
        $settings = $formConfig[PostConfig::POST_SETTINGS] ?? array();

        if (isset($settings[Option::CPT_NAME])) {
            $this->customPostTypes[$settings[Option::CPT_NAME]] = $formConfig;
        }
    }

    public function getCustomPostType($postType) {
        return $this->customPostTypes[$postType] ?? null;
    }

    public function getAttrs() {
        return $this->attrs;
    }

    public function getLicenseKey() {
        return PostUtils::getInstance()->getOption(Constants::IAKPRESS_KEY, '');
    }

    public function getLicensePcode() {
        return PostUtils::getInstance()->getOption(Constants::IAKPRESS_PCODE, '');
    }

    public function getLicenseExp() {
        return PostUtils::getInstance()->getOption(Constants::IAKPRESS_LICENSE_EXP, '');
    }

    public function getIAKFrontHeaderId() {
        return PostUtils::getInstance()->getOption(Constants::IAKFRONT_HEADER_ID, '');
    }

    public function getIAKFrontHeaderTitle() {
        return PostUtils::getInstance()->getOption(Constants::IAKFRONT_HEADER_TITLE, '');
    }

    public function getIAKFrontNavbarClass() {
        return PostUtils::getInstance()->getOption(Constants::IAKFRONT_NAVBAR_CLASS, '');
    }

    public function getIAKFrontFooterId() {
        return PostUtils::getInstance()->getOption(Constants::IAKFRONT_FOOTER_ID, '');
    }

    public function getIAKFrontFooterTitle() {
        return PostUtils::getInstance()->getOption(Constants::IAKFRONT_FOOTER_TITLE, '');
    }


    public function setPluginPrefix($val) {
        $this->attrs[self::PLUGIN_PREFIX] = $val;
        return $this;
    }

    public function getPluginPrefix() {
        return $this->attrs[self::PLUGIN_PREFIX];
    }

    public function setPluginUrl($val) {
        $this->attrs[self::PLUGIN_URL] = $val;
        return $this;
    }

    public function getPluginUrl() {
        return $this->attrs[self::PLUGIN_URL];
    }
    
    public function setPluginDir($val) {
        $this->pluginDir = $val;
        return $this;
    }

    public function getPluginDir() {
        return $this->pluginDir;
    }

    public function setPage($val) {
        $this->attrs[self::PAGE] = $val;
        return $this;
    }

    public function getPage() {
        return $this->attrs[self::PAGE];
    }


    public function setTimezone($val) {
        $this->attrs[self::TIMEZONE] = $val;
        return $this;
    }

    public function getTimezone() {
        return $this->attrs[self::TIMEZONE];
    }

    public function setIsDevEnv($val) {
        $this->attrs[self::IS_DEV_ENV] = $val;
        return $this;
    }

    public function getIsDevEnv() {
        return $this->attrs[self::IS_DEV_ENV];
    }

    public function setEnableDebug($val) {
        $this->attrs[self::ENABLE_DEBUG] = $val;
        return $this;
    }

    public function getEnableDebug() {
        return $this->attrs[self::ENABLE_DEBUG];
    }

    public function setSiteUrl($val) {
        $this->attrs[self::SITE_URL] = $val;
        return $this;
    }

    public function getSiteUrl() {
        return $this->attrs[self::SITE_URL];
    }


    public function setAdminAjaxUrl($val) {
        $this->attrs[self::ADMIN_AJAX_URL] = $val;
        return $this;
    }

    public function getAdminAjaxUrl() {
        return $this->attrs[self::ADMIN_AJAX_URL];
    }

    public function setAjaxUrl($val) {
        $this->attrs[self::AJAX_URL] = $val;
        return $this;
    }

    public function getAjaxUrl() {
        return $this->attrs[self::AJAX_URL];
    }
    
    public function setAdminHomeUrl($val) {
        $this->attrs[self::ADMIN_HOME_URL] = $val;
        return $this;
    }

    public function getAdminHomeUrl() {
        return $this->attrs[self::ADMIN_HOME_URL];
    }

    public function setStaticUrl($val) {
        $this->attrs[self::STATIC_URL] = $val;
        return $this;
    }

    public function getStaticUrl() {
        return $this->attrs[self::STATIC_URL];
    }

    public function setAdminPostUrl($val) {
        $this->attrs[self::ADMIN_POST_URL] = $val;
        return $this;
    }

    public function getAdminPostUrl() {
        return $this->attrs[self::ADMIN_POST_URL];
    }

    public function setPathInfo($val) {
        $this->attrs[self::PATH_INFO] = $val;
        return $this;
    }

    public function getPathInfo() {
        return $this->attrs[self::PATH_INFO];
    }

    public function setSiteName($val) {
        $this->attrs[self::SITE_NAME] = $val;
        return $this;
    }

    public function getSiteName() {
        return $this->attrs[self::SITE_NAME];
    }

    public function setSiteDesc($val) {
        $this->attrs[self::SITE_DESC] = $val;
        return $this;
    }

    public function getSiteDesc() {
        return $this->attrs[self::SITE_DESC];
    }

    public function setAdminEmail($val) {
        $this->attrs[self::ADMIN_EMAIL] = $val;
        return $this;
    }

    public function getAdminEmail() {
        return $this->attrs[self::ADMIN_EMAIL];
    }

    public function setUploadBaseDir($val) {
        $this->attrs[self::UPLOAD_BASEDIR] = $val;
        return $this;
    }

    public function getUploadBaseDir() {
        return $this->attrs[self::UPLOAD_BASEDIR];
    }

    public function setRequestType($val) {
        $this->attrs[self::REQUEST_TYPE] = $val;
        return $this;
    }

    public function getRequestType() {
        return $this->attrs[self::REQUEST_TYPE];
    }

    public function setIsInternalRequest($val) {
        $this->attrs[self::IS_INTERNAL_REQUEST] = $val;
        return $this;
    }

    public function getIsInternalRequest() {
        return $this->attrs[self::IS_INTERNAL_REQUEST];
    }

    public function setPostType($val) {
        $this->attrs[self::POST_TYPE] = $val;
        return $this;
    }

    public function getPostType() {
        return $this->attrs[self::POST_TYPE];
    }

    public function getUserCanManage() {
       return PostUtils::getInstance()->getUserCanManage();
    }

    public function hasBlocks() {
        return PostUtils::getInstance()->hasBlocks();
    }
    
    public function getTablePrefix() {
        return $this->tablePrefix;
    }

    public function setTablePrefix($tablePrefix) {
        $this->tablePrefix = $tablePrefix;
    }

    public function setLicenceGetUrl($val) {
        $this->attrs[self::LICENCE_GET_URL] = $val;
        return $this;
    }

    public function getLicenceGetUrl() {
        return $this->attrs[self::LICENCE_GET_URL];
    }

    public function getIAKTinymcePluginUrl() {
        return sprintf(
            '%s/public/js/iaktinymce.bundle.js',
            $this->getPluginUrl()
        );
    }

    public function renderAdminFooter(array $params) {
        static $isAdminClientConfigRendered;

        if (!$isAdminClientConfigRendered) {
            $isAdminClientConfigRendered = true;
            echo  $this->doRenderClientConfig($params);
        }
    }

    public function renderFrontClientConfig(array $params) {
        static $isClientConfigRendered;

        if (!$isClientConfigRendered) {
            $isClientConfigRendered = true;
            echo  $this->doRenderClientConfig($params);
        }
    }

    public function doRenderClientConfig(array $params) {
        return  $this->getTwig()->render(
            'clientconfig.html.twig', 
            array_merge(
                [
                    'params' => $params
                 ]
            )
        );
    }

    public function renderTemplate($template, $postType, array $dataItems = array()) {
        $formData = $dataItems[PostConfig::POST_CONFIG_DATA_KEY] ?? "{}";
        $formElementId = $dataItems[PostConfig::POST_CONFIG_ELEMENT_ID] ?? "iablock";
        $formValuesElementId = $dataItems[PostConfig::POST_CONFIG_VALUES_ELEMENT_ID] ?? "iaPOST_CONFIG_values";
        $formErrorsElementId = $dataItems[PostConfig::POST_CONFIG_ERRORS_ELEMENT_ID] ?? "iaPOST_CONFIG_errors";
        $formPreviewUrl = $dataItems[PostConfig::POST_CONFIG_PREVIEW_URL] ?? "";
        $frontBundleName = $dataItems[Constants::FRONT_BUNDLE_NAME] ?? Constants::FRONT_JS;
        $moduleName = $dataItems[Constants::MODULE_NAME] ?? "";
        $isArchive = $dataItems[Constants::IS_ARCHIVE] ?? true;
        $moduleUrl = $dataItems[Constants::IAKPRESS_MODULE_URL] ?? "";

        $domElementId = "iakpress_editor";

        $formType = 0;

        if (isset($dataItems[PostConfig::POST_CONFIG_CONFIG_KEY])) {
            $formConfig = $dataItems[PostConfig::POST_CONFIG_CONFIG_KEY];
            $domElementId = "iakpost_". $formConfig[Constants::ID];

            $formType = $formConfig[PostConfig::POST_CONFIG_TYPE] ?? 0;
        } else {
            $formConfig = "{}";
        }



        $clientConfig = array_merge(
            $dataItems[PostConfig::CLIENT_CONFIG_KEY] ?? [],
            [
                Constants::POST_TYPE => $postType
            ]
        );

        $config =  !PostUtils::getInstance()->isAdmin() ? $this->renderFrontClientConfig($clientConfig) : "";

        $output = $this->getTwig()->render(
                                            $template, 
                                            [
                                                 Constants::IS_PRO_VERSION => $this->getIsProVersionStr(),
                                                 PostConfig::POST_CONFIG_CONFIG_KEY => $formConfig,
                                                 PostConfig::POST_CONFIG_DATA_KEY => $formData,
                                                 PostConfig::POST_CONFIG_ELEMENT_ID => $formElementId,
                                                 PostConfig::POST_CONFIG_VALUES_ELEMENT_ID => $formValuesElementId,
                                                 PostConfig::POST_CONFIG_ERRORS_ELEMENT_ID => $formErrorsElementId,
                                                 PostConfig::POST_CONFIG_PREVIEW_URL => $formPreviewUrl,
                                                 Constants::POST_TYPE => $postType,
                                                 Constants::FORM_TYPE => $formType,
                                                 self::STATIC_URL => $this->getStaticUrl(),
                                                 Constants::IS_CPT => TemplateTypes::isCustomPostType($formConfig[PostConfig::POST_CONFIG_TYPE] ?? 0),
                                                 Constants::FRONT_BUNDLE_NAME => $frontBundleName,
                                                 Constants::MODULE_NAME => $moduleName,
                                                 Constants::IAKPRESS_MODULE_URL => $moduleUrl,
                                                 Constants::DOM_ELEMENT_ID => $domElementId,
                                                 Constants::IS_ARCHIVE => $isArchive
                                             ]
                                        );

        return $config. $output;
    }
}
