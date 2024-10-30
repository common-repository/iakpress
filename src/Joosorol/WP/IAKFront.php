<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\IAKPress\IAPost\ClientConfig;
use App\Joosorol\IAKPress\IALabel\LabelKey;
use App\Joosorol\WP\IAModel\PostConfigModel;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;

/**
 * Description of IAKFront
 *
 * @author bly
 */
class IAKFront
{
    const FRONT_POST_TEMPLATE = 'index.html';
    const THEME_TEMPLATE = 'theme.html.twig';

    const FRONT_MODULE_NAME = 'front';

    const MODULE_URL_PATTERN = "{{iakpress_module_url}}";

    /**
     * @var IAKFront The single instance of the class
     */
    private static $sInstance = null;

    /**
     * Main IAKFront Instance
     *
     * Ensures only one instance of IAKFront is loaded or can be
     * loaded.
     *
     * @static
     * @return IAKFront - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    private function __construct()
    {
         PluginInterface::getInstance()->setAssets($this->doGetAssets());

         add_action('wp_loaded', array($this, 'registerAllScripts'));
 
         add_action('wp_enqueue_scripts', array($this, 'enqueueFrontCSS'));
         
    }

    public function doInit() {

    }

    public function doGetAssets(): array
    {
        $this->blockAssets();

        return array_merge(
            [
                Constants::IAKPRESS_ICON => PluginInterface::getInstance()->buildAssetUrl(Constants::IAKPRESS_ICON_FILE),

                Constants::ADMIN_CSS => PluginInterface::getInstance()->buildAssetUrl(Constants::ADMIN_CSS_FILE),
                Constants::FRONT_CSS => PluginInterface::getInstance()->buildAssetUrl(Constants::FRONT_CSS_FILE),

                Constants::BOOTSTRAP_CSS => PluginInterface::getInstance()->buildAssetUrl(Constants::BOOTSTRAP_CSS_FILE),

                Constants::IAK_COMMON_JS => PluginInterface::getInstance()->buildAssetUrl(Constants::IAK_COMMON_JS_FILE)
            ],

            $this->blockAssets()
        );
    }

    private function blockAssets() : array {
        $res = array();

        $maifestFileName = PluginInterface::getInstance()->getPluginDir() . "/public/blocks/asset-manifest.json";
        $content = file_get_contents($maifestFileName);
        $jsonConfig = json_decode($content, true);

        $moduleUrl = PluginInterface::getInstance()->getStaticUrl(). "/blocks";
        if ($jsonConfig !== null) {
            if (isset($jsonConfig["files"])) {
                $runtimeJsFileName = $jsonConfig["files"]["runtime-main.js"] ?? '';
                $runtimeJsFileName = str_replace(self::MODULE_URL_PATTERN, $moduleUrl,  $runtimeJsFileName);

                $mainJsFileName = $jsonConfig["files"]["main.js"] ?? '';
                $mainJsFileName = str_replace(self::MODULE_URL_PATTERN, $moduleUrl,  $mainJsFileName);

               return [
                    Constants::IAK_BLOCKS_RUNTIME_JS => $runtimeJsFileName,
                    Constants::IAK_BLOCKS_MAIN_JS => $mainJsFileName
               ];
            }
           
        }

        return $res;
    }


    public function getBodyClasses($bodyClasses)
    {
        return $bodyClasses;
    }

    public function isProVersion() {
        $proStaticUrl = get_option(Constants::PRO_STATIC_URL);
        
        return !empty($proStaticUrl);
    }

    /**
     * Enqueue Front Css
     */
    public function enqueueFrontCSS()
    {
        $post_type = get_post_type();
        global $post;
        
        $formConfig = PostUtils::getInstance()->getCurrentFormConfig();
        
        $shouldAddAssets = $post_type == Constants::IA_POST_CONFIG_POST_TYPE || !is_null($formConfig);

        if (!$shouldAddAssets) {
            $requestUri = $_SERVER["REQUEST_URI"] ?? '';
            $shouldAddAssets =  preg_match('#/iakpress-ui/#i', $requestUri);
        }

        if (!$shouldAddAssets && !is_null($post)) {
            $shouldAddAssets =  has_block(Constants::IAKPOST_BLOCK_NAME, $post) 
                                || has_shortcode($post->post_content, Constants::IAKPOST_SHORTCODE_NAME);
        }
        
        if ($shouldAddAssets) {
            // enqueue css stylesheets
            wp_enqueue_style(Constants::BOOTSTRAP_CSS);
            wp_enqueue_style('wp-components');
            wp_enqueue_style(Constants::FRONT_CSS);
        }
    }

    /**
     * Enqueue Front Js
     * @return enqueued js bundle name
     */
    public function enqueueFrontScriptsAndGetModuleName($formConfig): string
    {
        $formConfigType = intval($formConfig[PostConfig::POST_CONFIG_TYPE] ?? 0);

        
        switch ($formConfigType) {
            case TemplateTypes::FT_CONTACT_FORM:
            case TemplateTypes::FT_PHOTO_GALLERY:
            case TemplateTypes::FT_ADVANCED_FORM:
            case TemplateTypes::FT_SIGN_UP_FORM:
                return "iak". self::FRONT_MODULE_NAME;

            default:
                return '';
        }
    }

    public function registerAllScripts()
    {
        // register css styleshteets
        wp_register_style(
            Constants::FRONT_CSS,
            PluginInterface::getInstance()->getAssets()[Constants::FRONT_CSS],
            array(Constants::BOOTSTRAP_CSS, 'wp-components'),
            PluginInterface::VERSION
        );

        wp_register_style(
            Constants::BOOTSTRAP_CSS,
            PluginInterface::getInstance()->getAssets()[Constants::BOOTSTRAP_CSS],
            array(),
            PluginInterface::VERSION
        );
    }

    public function renderArchivePostView($formConfig, $formData = array())
    {
        return $this->doRenderForm($formConfig, $formData);
    }

    public function renderSinglePostView($formConfig, $formData = array())
    {
        return $this->doRenderForm($formConfig, $formData, array(), false);
    }

    public function renderForm($postId, $formData = array(), $formConfigAttrs = array())
    {
        $formConfig = PostConfigModel::getInstance()->fetchSingle($postId);

        return $this->doRenderForm($formConfig, $formData, $formConfigAttrs);
    }


    public function getModuleName($formConfig) : string {
        $formConfigType = intval($formConfig[PostConfig::POST_CONFIG_TYPE] ?? 0);

        switch ($formConfigType) {
            case TemplateTypes::FT_CONTACT_FORM:
            case TemplateTypes::FT_PHOTO_GALLERY:
            case TemplateTypes::FT_ADVANCED_FORM:
            case TemplateTypes::FT_SIGN_UP_FORM: 
                return self::FRONT_MODULE_NAME;

            default:
                return '';
        }
    }

    public function doRenderForm($formConfig, array $formData = array(), array $formConfigAttrs = array(), bool $isArchive = true)
    {
        if (!is_null($formConfig)) {
            $assetKey = $this->enqueueFrontScriptsAndGetModuleName($formConfig);
            $moduleName = $this->getModuleName($formConfig);

            if (!empty($formConfigAttrs)) {
                $oldSettings =  $formConfig[PostConfig::POST_SETTINGS] ?? array();
                $formConfig[PostConfig::POST_SETTINGS] = array_merge($oldSettings, $formConfigAttrs);
            }


            if (!empty($assetKey)) {
                $content = PluginInterface::getInstance()->renderTemplate(
                    $moduleName . "/". self::FRONT_POST_TEMPLATE,
                    Constants::IA_POST_CONFIG_POST_TYPE,
                    [
                        PostConfig::CLIENT_CONFIG_KEY => ClientConfig::getInstance()->getFrontConfig(Constants::IA_POST_CONFIG_POST_TYPE),
                        PostConfig::POST_CONFIG_CONFIG_KEY => $formConfig,
                        PostConfig::POST_CONFIG_DATA_KEY => $formData,
                        Constants::POST_TYPE => Constants::IA_POST_CONFIG_POST_TYPE,
                        Constants::FRONT_BUNDLE_NAME => $assetKey,
                        Constants::MODULE_NAME => $moduleName,
                        Constants::PAGE_TYPE => Constants::FRONT_PAGE_TYPE,
                        Constants::IS_ARCHIVE => $isArchive ? "true" : "false",
                        Constants::IAKPRESS_MODULE_URL => PluginInterface::getInstance()->getStaticUrl(). "/front"
                    ]
                );

                return $content;
            } else {
                return sprintf('<div class="bg-warning p-3">%s</div>', FieldLabels::translate(LabelKey::UNABLE_TO_RENDER_POST));
            }
        } else {
            return '';
        }
    }
}
