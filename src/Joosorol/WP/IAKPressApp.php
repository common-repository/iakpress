<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP;

use App\Joosorol\WP\Admin\ApiKeysAdmin;
use App\Joosorol\WP\Admin\ChoiceGroupAdmin;
use App\Joosorol\WP\Admin\CPTAdmin;
use App\Joosorol\WP\Admin\FieldConfigAdmin;
use App\Joosorol\WP\Admin\FormEntryAdmin;
use App\Joosorol\WP\Admin\PostConfigAdmin;
use App\Kernel;
use App\Joosorol\IAKPress\IAPost\BaseApp;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\IAKPress\IAPost\ClientConfig;
use App\Joosorol\WP\IAModel\ChoiceGroupModel;
use App\Joosorol\IAKPress\IAModel\EntryStatus;
use App\Joosorol\WP\IAModel\PostConfigModel;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use App\Joosorol\WP\Admin\GenericSessionAdmin;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of IAKPressApp
 *
 * @author bly
 */
class IAKPressApp extends BaseApp
{
    const PAGE_NAME = 'IAKPress';
    const POST_TYPE = 'iapost';
    const APP_TITLE = 'IAK Press';
    const DASHBOARD_TITLE = 'Dashboard';
    const TOP_NAV_MENU_SLUG = Constants::SUBSCRIPTION_PAGE_NAME;
    const DASHBOARD_SLUG = 'dashboard';

    const DASH_TEMPLATE = 'dash/index.html';
    const SUBSCRIPTION_TEMPLATE = 'subscription-page.html.twig';

    const SUBSCRIPTION_PAGE_NAME = Constants::SUBSCRIPTION_PAGE_NAME;
    const SUBSCRIPTION_PAGE_TITLE = 'IAKPress';

    const IAKPRESS_BLOCKS = 'iakpress-blocks';
    const IAKPRESS_BLOCKS_LABEL = 'IAKPress Blocks';

    const ADD_ONS_PAGE_NAME = Constants::ADD_ONS_PAGE_NAME;
    const ADD_ONS_PAGE_TITLE = 'Add-Ons';
    const ADD_ONS_TEMPLATE = 'addons-page.html.twig';


    private ?Kernel $kernel = null;


    /**
     * @var IAKPressApp The single instance of the class
     */
    private static $sInstance = null;

    /**
     * Main IAKPressApp Instance
     *
     * Ensures only one instance of IAKPressApp is loaded or can be
     * loaded.
     *
     * @static
     * @return IAKPressApp - Main instance
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


        $this->addPostAdmin(new PostConfigAdmin());
        $this->addPostAdmin(new CPTAdmin());
        $this->addPostAdmin(new ApiKeysAdmin());
        $this->addPostAdmin(new FieldConfigAdmin());
        $this->addPostAdmin(new ChoiceGroupAdmin());
        $this->addPostAdmin(new FormEntryAdmin());
        $this->addPostAdmin(new GenericSessionAdmin());
    }

    public function getCurrentPostType() {
        $type = get_post_type();

        if (!$type) {
            global $post_type;
            return $post_type;
        }

        return $type;
    }

    public function shouldProcess()
    {
        if ($this->isIAKPostConfigType() || $this->isIAKCustomPostType()) {
            return true;
        }


        if (!empty($_GET[Constants::IAKPRESS_QVAR]) || !empty($_GET[Constants::IAKPRESS_UI_QVAR])) {
            return true;
        }

        $page = filter_input(INPUT_GET, 'page');

        if ($page == Constants::IA_DASH_PAGE 
            || $page == self::SUBSCRIPTION_PAGE_NAME
            || $page == self::ADD_ONS_PAGE_NAME) {
            return true;
        }

        $screen = get_current_screen();
        if (!is_null($screen) && $screen->is_block_editor) {
            return true;
        }

        global $post;


        if (!is_null($post)) {
            return has_block(Constants::IAKPOST_BLOCK_NAME, $post) 
                    || has_shortcode($post->post_content, Constants::IAKPOST_SHORTCODE_NAME);
        }

        return false;
    }

    public function doGetAssets(): array
    {
        return IAKFront::getInstance()->doGetAssets();
    }

    protected static function getSubscriptionPageTitle() {
        $coutEntries = PostUtils::getInstance()->countEntriesByStatusId(EntryStatus::STATUS_UNREAD);
        if ($coutEntries > 0) {
            return '<div>IAKPress <span class="update-plugins count-'. $coutEntries .'"><span class="plugin-count">'.$coutEntries.'</span></span></div>';
        } else {
            return self::SUBSCRIPTION_PAGE_TITLE;
        }
    }

    public function addAdminMenuPage()
    {
        add_menu_page(
            'IAKPress Dashboard',
            self::getSubscriptionPageTitle(),
            'manage_options',
            self::SUBSCRIPTION_PAGE_NAME,
            array($this, 'renderSubscriptionPage'),
            PluginInterface::getInstance()->getPluginIconUrl(),
            6
        );
    }

    public function renderSubscriptionPage()
    {
         // hidden editor config used to edit field content
         echo '<div style="display: none;">';
         wp_editor('', Constants::IAK_CONTENT_CONFIG);
         echo '</div>';    
         
        $output = $this->renderTemplate(
            self::DASH_TEMPLATE,
            self::POST_TYPE,
            [
                PostConfig::CLIENT_CONFIG_KEY => ClientConfig::getInstance()->getFrontConfig(self::POST_TYPE),
                Constants::PAGE_TYPE => Constants::EDITOR_PAGE_TYPE,
                Constants::FRONT_BUNDLE_NAME => "iakdash",
                Constants::IAKPRESS_MODULE_URL => PluginInterface::getInstance()->getStaticUrl(). "/dash"
            ]
        );

        echo $output;
    }



    public function doInit()
    {
        add_action('admin_menu', array($this, 'addAdminMenuPage'), 0);

        add_action('wp_head', array($this, 'head'));
        add_action('admin_head', array($this, 'adminHead'));

        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
		
		add_filter( 'wp_title', array($this, 'filterTitle'), 10, 2);


        add_filter('the_content', array($this, 'filterContent'));

        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminCSS'));

        // render client config
        add_action( 'admin_footer', array($this, 'renderAdminFooter'), 10, 1 ); 

        add_filter( 'block_categories_all', array($this, 'extendBlockCategories'), 10, 2 );

        add_filter( 'wp_editor_settings', function( $settings ) {
           $settings['media_buttons'] = false;
        
            return $settings;
        } );

        add_filter( 'mce_buttons', function( $settings ) {
            return array(
                'formatselect, bold, italic, underline, bullist, numlist, blockquote, link, image, alignleft, aligncenter, alignright, alignjustify, wp_more, wp_adv'
            );
         }, 
         0 
        );

        add_filter( 'mce_buttons_2', function( $settings ) {
            return array('strikethrough, forecolor, outdent, indent, pastetext, removeformat, wp_help');
         }, 
         0 
        );


        IAKFront::getInstance()->doInit();
        
        IAKBlocks::register();
    }

    public function isIAKPostConfigType() {
        $inputPostType = $this->getInputPostType();
        return $inputPostType == Constants::IA_POST_CONFIG_POST_TYPE ||
            $inputPostType == Constants::IA_FIELD_POST_TYPE ||
            $inputPostType == Constants::IA_API_KEYS_POST_TYPE;
    }

    public function isIAKCustomPostType() {
        $inputPostType = $this->getInputPostType();
        // check if inputPostType is IAK Custom Post Type.
        $entries = ChoiceGroupModel::getInstance()->fetchCPTList();

        foreach($entries as $formConfig) {
            $settings = $formConfig[PostConfig::POST_SETTINGS] ?? array();
            $cptName =  $settings[Option::CPT_NAME] ?? '';
            if ($cptName == $inputPostType) {
                return true;
            }
        }

        return false;
    }

    public function renderAdminFooter() {

        PluginInterface::getInstance()->renderAdminFooter(
            ClientConfig::getInstance()->getFrontConfig($this->getCurrentPostType()));
    }

    public function extendBlockCategories($categories, $post) {
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => self::IAKPRESS_BLOCKS,
                    'title' => self::IAKPRESS_BLOCKS_LABEL,
                ),
            )
        );
    }

    public function head()
    {
        if (get_post_type() === Constants::IA_POST_CONFIG_POST_TYPE) {
            // Check if we're inside the main loop in a single post page.
            global $post;        

            $title = sprintf("%s : %s", $post->post_title, PluginInterface::getInstance()->getSiteName());
            echo '
                <meta property="og:title" content="'. $title .'" />
                <meta name="twitter:title" content="'. $title .'" />
            ';

            
            $metaDesc = PostUtils::getInstance()->getPostMeta($post->ID, PostConfig::POST_CONFIG_META_DESC, true);
            
            if (!empty($metaDesc)) {
                echo '
                    <meta name="description" content="'. $metaDesc . '" />
                    <meta property="og:description" content="'. $metaDesc. '" />
                    <meta name="twitter:description" content="'. $metaDesc. '" />
                ';
            }
                
            $metaKeys = PostUtils::getInstance()->getPostMeta($post->ID, PostConfig::POST_CONFIG_META_KEYWORDS, true);
            if (!empty($metaKeys)) {
                $keywords = sprintf("%s, %s", $metaKeys, PluginInterface::getInstance()->getSiteName());

                echo '
                    <meta name="keywords" content="'. $keywords . '" />
                ';
            }
        }

        $this->printIAKAddLoadEventFunc();
    }

    public function adminHead() {
        $this->printIAKAddLoadEventFunc();
    }

    public function printIAKAddLoadEventFunc() {
        $jsPath = PluginInterface::getInstance()->getStaticUrl();
        $blocksPath = PluginInterface::getInstance()->getStaticUrl(). '/blocks/';
        $cssPath = PluginInterface::getInstance()->getStaticUrl(). '/css/';

        echo "
        <script type=\"text/javascript\">
            function iakAddLoadEvent(func) {
            var oldonload = window.onload;
            if (typeof window.onload != 'function') {
                window.onload = func;
            } else {
                window.onload = function() {
                    if (oldonload) {
                        oldonload();
                    }
                    func();
                }
            }
        }
       </script>";
    }

    /**
     * Enqueue Admin Css
     */
    public function enqueueAdminCSS()
    {
        if ($this->shouldProcess()) {
            wp_enqueue_style(Constants::BOOTSTRAP_CSS);
            wp_enqueue_style(Constants::ADMIN_CSS);
            wp_enqueue_style(Constants::FRONT_CSS);
        }
    }
    /**
     * Enqueue Jss & Css Scripts
     */
    public function enqueueAdminScripts()
    {
        if ($this->shouldProcess()) {
            if (is_admin()) {    
                wp_enqueue_script('wp-components');
                wp_enqueue_media();
                wp_enqueue_script('media-uploader');
                wp_enqueue_editor();

            } else {
                wp_enqueue_script('jquery');
            }
        }
    }

    /**
     * Handle http request
     */
    public function handle()
    {
        try {
            $this->response = $this->kernel->handle($this->getOrCreateRequest());

            return $this->response;
        } catch (\Throwable $throwable){
            echo "Exception ";
            var_dump($throwable);
            exit;
        }        
    }

    /**
     * Handle http request, send the response to the client and terminate the script
     */
    public function handleAndTerminate()
    {
        $this->bootKernel();

        $response = $this->handle();
        $response->send();

        exit;
    }

    /**
     * Handle http request, get the response
     */
    public function handleAndGetResponse()
    {
        $this->bootKernel();

        $response = $this->handle();

        return $response;
    }

    public function renderUI() {
        $response = $this->handleAndGetResponse();

        if ($response->isSuccessful()) {
            get_header();

            echo '<div class="wrap"><section id="primary" class="content-area">
                        <div id="content" class="site-content" role="main">'
                    
                                        . $response->getContent() 
                                    
                    . ' </div>
                    </section>
                </div>s';

            get_footer();
        } else {
            status_header( 404 );
            nocache_headers();

            get_header();

            echo '<div class="error-404 not-found"><header class="page-header"><h1 class="page-title">'
                    . _e( 'Oops! That page can&rsquo;t be found.', '' )
                    .  '</h1></header></div>';

            get_footer();
        }

        exit;
    }

    /**
     * Get $kernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }


    /**
     * Get Site Info
     */
    public function getSiteURL()
    {
        return PluginInterface::getInstance()->getSiteUrl();
    }

    public function bootKernel() : void {
        if (is_null($this->kernel) || !$this->kernel->getIsBooted()) { 
            $isDev = defined('IAK_DEBUG') ? IAK_DEBUG : false;
            if ($isDev) {
                umask(0000);
                $env = 'dev';
            } else {
                $env = 'prod';
            }
    
            $this->kernel = new Kernel($env, $isDev);

            $this->kernel->boot();

            $request = $this->getOrCreateRequest();
            PostUtils::getInstance()->setIsWebpSupported(false !== mb_stripos($request->headers->get('accept', ''), 'image/webp'));
        }
    }

    public function handleAction()
    {
        $relativeUrl =  sanitize_text_field($_GET['relativeUrl']) ?? '';

        // we modify the request uri to our relativeUrl to
        // make rest requests happy
        $_SERVER['REQUEST_URI'] = $relativeUrl;


        $this->bootKernel();

        $response = $this->handle();
        $response->send();

        exit;
    }

    public function filterContent($content)
    {
        if (get_post_type() === Constants::IA_POST_CONFIG_POST_TYPE) {
            // Check if we're inside the main loop in a single post page.
            if (is_single() && in_the_loop() && is_main_query()) {
                return $content. $this->renderForm();
            }
        }
        

        return $content;
    }
	
	public function filterTitle($title, $sep)
    {
        if (get_post_type() === Constants::IA_POST_CONFIG_POST_TYPE) {
            // Check if we're inside the main loop in a single post page.
            if (is_single() && in_the_loop() && is_main_query()) {
				global $post;
                				
                return  sprintf("%s : %s", $post->post_title, PluginInterface::getInstance()->getSiteName());
            }
        }

        return $title;
    }

    public function renderForm()
    {
        $this->bootKernel();

        global $post;

        if (!is_null($post)) {
            $currentPostId = $post->ID;

            $formConfig = PostConfigModel::getInstance()->fetchSingle($currentPostId);
    
            return IAKFront::getInstance()->doRenderForm($formConfig);
        }

        return "";
    }
}
