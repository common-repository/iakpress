<?php

/**
 * @package IAKPress
 * @version 1.3.2
 */

/**
 * Plugin Name: IAKPress - Exam Quiz, Form Builder, Page Builder
 * Plugin URI: https://iakpress.com/
 * Description: IAKPress is a content builder plugin that helps you build forms, quizzes, galleries and more. It can also help you create and manage custom post types and taxonomies, which lets you unlock WordPress' power as a full content management system.
 * Author: IAKPress Team
 * Version: 1.3.2
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: iakpress
 * 
 * Domain Path: /languages
 *
 * IAKPress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, ornpm
 * any later version.
 *
 * IAKPress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with IAKPress. If not, see <http://www.gnu.org/licenses/>.
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use App\Joosorol\WP\IAKFront;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\WP\IAKPressApp;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\WP\IAModel\ApiKeysModel;
use App\Joosorol\WP\IAModel\PostConfigModel;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;


if (!class_exists('WP_IAKPress')) :

    /**
     * Main WP_IAKPress Class
     *
     * @class WP_IAKPress
     */
    final class WP_IAKPress {
        const PLUGIN_PREFIX = 'iakpress';
        const IAKPRESS_QVAR = 'iakpressq';

        const PLUGIN_UI_PREFIX = 'iakpress-ui';
        const IAKPRESS_UI_QVAR = 'iakpressuiq';

        const EMPTY_POST_ID_GIVEN = 'Empty Post ID Given';

        /**
         * @var IAKPressApp
         */
        private $app;

        /**
         * @var WP_IAKPress The single instance of the class
         */
        private static $sInstance = null;


        /**
         * Main WP_IAKPress Instance
         *
         * Ensures only one instance of WP_IAKPress is loaded or can be loaded.
         *
         * @static
         * @return WP_IAKPress - Main instance
         */
        public static function getInstance() {
            if (is_null(self::$sInstance)) {
                self::$sInstance = new self();
            }
            return self::$sInstance;
        }
        
        
        /**
         * static method to get version
         */
        public static function getPluginVersion() {
            return self::getInstance()->getVersion();
        }

        /**
         * Get plugin url
         */
        public static function getPluginUrl() {
            return plugins_url(plugin_basename(dirname(__FILE__)));
        }

        /**
         * Get plugin static url
         */
        public static function getStaticUrl() {
            return self::getPluginUrl() . "/public";
        }

        /**
         * Get plugin ajax admin url
         */
        public static function getAdminAjaxUrl() {
            return admin_url('admin-ajax.php?action=iak_handle_action');
        }

        /**
         * Get plugin ajax public url
         */
        public static function getAjaxUrl() {
            return self::getSiteUrl(). '?action=iak_handle_action';
        }

        /**
         * Get Site Info
         */
        public static function getSiteURL() {
            return get_bloginfo('url');
        }

        public static function getPluginDir() {
            return plugin_dir_path(__FILE__);
        }

        /**
         * Get admin post Url
         */
        public static function getAdminPostUrl() {
            $url = esc_url(admin_url('admin-post.php'));
            return $url;
        }

        public static function getSiteName() {
            return get_bloginfo('name');
        }

        public static function getSiteDescription() {
            return get_bloginfo('description');
        }

        public static function getAdminEmail() {
            return get_bloginfo('admin_email');
        }

        /**
         * Secure IAKPress API requests
         */
        public static function getNonceKey() {
            return self::PLUGIN_PREFIX."-nonce-key";
        }

        public static function createToken($nonceKey = "") {
            $key = $nonceKey !== "" ?: self::getNonceKey();
            return wp_create_nonce($key);
        }

        public static function IsTokenValid($token, $nonceKey = "") {
            if (is_null($token)) {
                return false;
            }
            $key = $nonceKey !== "" ?: self::getNonceKey();
            return wp_verify_nonce($nonceKey, $key);
        }

        /**
         * WP_IAKPress Constructor.
         */
        private function __construct() {
            $this->includes();
            
            $this->app = $this->createApp();
			           
            $this->initHooks();
        }
        
        /**
         * Create application instance
         */
        private function createApp() {            
            PluginInterface::getInstance()->setPluginPrefix(self::PLUGIN_PREFIX);
            PluginInterface::getInstance()->setPluginUrl(self::getPluginUrl());
            PluginInterface::getInstance()->setPluginDir(self::getPluginDir());
            PluginInterface::getInstance()->setStaticUrl(self::getStaticUrl());
            PluginInterface::getInstance()->setSiteUrl(self::getSiteURL());
            PluginInterface::getInstance()->setSiteName(self::getSiteName());
            PluginInterface::getInstance()->setAdminAjaxUrl(self::getAdminAjaxUrl());
            PluginInterface::getInstance()->setAjaxUrl(self::getAjaxUrl());
            //PluginInterface::getInstance()->setIsDevEnv(WP_DEBUG);
            
            global $wpdb;
            PluginInterface::getInstance()->setTablePrefix($wpdb->prefix);
      
            $app =  IAKPressApp::getInstance();
            
            return $app;
        }
        
        /**
         * @return $this->app
         */
        public function getApp() {
            return $this->app;
        }

        /**
         * Include required core files used in admin and on the frontend.
         */
        public function includes() {
            include_once(__DIR__."/vendor/autoload.php");
        }

        /**
         * Rewrite rules
         */
        public function addRewriteRules() {
            global $wp_rewrite;

            $new_rules = array(
                        '('.self::PLUGIN_PREFIX.')/(.*?)/?$' => 'index.php?'.self::IAKPRESS_QVAR.'='
                        . $wp_rewrite->preg_index(1),
                        '('.self::PLUGIN_PREFIX.')/?$' => 'index.php?'.self::IAKPRESS_QVAR.'='
                        . $wp_rewrite->preg_index(1),

                        '('.self::PLUGIN_UI_PREFIX.')/(.*?)/?$' => 'index.php?'.self::IAKPRESS_UI_QVAR.'='
                        . $wp_rewrite->preg_index(1),
                        '('.self::PLUGIN_UI_PREFIX.')/?$' => 'index.php?'.self::IAKPRESS_UI_QVAR.'='
                        . $wp_rewrite->preg_index(1)
            );
            


            // Always add your rules to the top, to make sure your rules have priority
            $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
        }

        /**
         * Add new query vars.
         *
         * @param $vars
         * @return string[]
         */
        public function addQureryVars($vars) {
            $vars[] = self::PLUGIN_PREFIX;
            $vars[] = self::IAKPRESS_QVAR;

            $vars[] = self::PLUGIN_UI_PREFIX;
            $vars[] = self::IAKPRESS_UI_QVAR;
            return $vars;
        }

        /**
         * Prettyfy Permalink
         */
        public function prettyPermalinks() {
            if (!get_option('permalink_structure')) {
                update_option('permalink_structure', '/%postname%/');
                apply_filters('mod_rewrite_rules', '/%postname%/');
                $this->flushRewriteRules();
            }
        }

        public function registerBlocks()
        {
            if (PluginInterface::getInstance()->hasBlocks()) {
                register_block_type(Constants::IAKPOST_BLOCK_NAME, array(
                    'editor_script' => Constants::IAK_BLOCKS_MAIN_JS,
                    'attributes' => array(
                        'iakpost_id' => array('type' => 'number')
                    ),
                    'render_callback' => array($this, 'renderBlockIAKPost')
                ));
            }
        }

        public function loadTextDomain() {
            load_plugin_textdomain(Constants::IAKPRESS, false, self::getPluginDir() . '/languages' ); 
        }

        /**
         * Flush rewrite rules
         */
        public function flushRewriteRules() {
            global $wp_rewrite;

            $wp_rewrite->flush_rules();
        }
        
        /**
         * Create Admin Pages
         */
        public function addAdminMenuPage() {
            $this->getApp()->addAdminMenuPage();
        }
        

        /**
         * Wordpress User
         */
        public static function getCurrentUser() {
            return wp_get_current_user();
        }

        public static function getCurrentUserID() {
            $current_user = wp_get_current_user();
            $id = $current_user->ID;
            return isset($id) ? $id : false;
        }

        public static function getCurrentUserRole() {
            global $wp_roles;
            $current_user = wp_get_current_user();
            $roles = $current_user->roles;
            $role = array_shift($roles);
            return isset($wp_roles->role_names[$role]) ? array($role, translate_user_role($wp_roles->role_names[$role])) : false;
        }

        public static function userLoggedIn() {
            return is_user_logged_in();
        }


        public static function getUploadBaseDir() {
            $upload_dir = wp_upload_dir();
            return $upload_dir['basedir'];
        }

        public static function getCacheDir(): string
        {
            $env = defined('IAK_DEBUG') ? "dev" : "prod";
            return __DIR__.'/var/cache/'.$env;
        }
    
        public static function getLogDir(): string
        {
            return __DIR__.'/var/log';
        }

        /**
         * Hook into actions and filters
         */
        private function initHooks() {
            register_activation_hook(__FILE__, array($this, 'prettyPermalinks'));
            
            register_activation_hook(__FILE__, array($this, 'pluginInstall'));

            add_action( 'plugins_loaded', array($this, 'pluginUpdate'));


            register_deactivation_hook(__FILE__, array($this, 'pluginUninstall'));

            register_uninstall_hook(__FILE__, 'pluginUninstall');

            add_action('init', array($this, 'flushRewriteRules'), 0);


            add_action('init', array($this, 'registerBlocks'), 0);

            add_action('init', array($this, 'loadTextDomain'));

            add_action('generate_rewrite_rules', array($this, 'addRewriteRules'), 0);

            add_filter('query_vars', array($this, 'addQureryVars'), 0);

            //add_action('wp_login', array($this, 'onUserLoggedIn'), 10, 2);

            //add_action( 'wp_logout', array($this, 'onUserLogout'),  10, 1);


            // add shortcode functions
            add_shortcode('iakpost', array($this, 'renderShortcodeIAKPost'));

            
            // handle requests
            add_action( 'parse_request', array($this, 'handleRequest' ), 0 );

            // add IAKPress filters
            $this->getApp()->init();
        }
        
        /**
         * Register IAKPress post types
         */
        public function registerPostTypes() {
            $this->getApp()->registerPostTypes();
        }
        

         /**
         * Handle IAKPress API requests
         */
        public function handleRequest() {
            global $wp;

             // iakpress plugin requests
            if ( ! empty( $_GET[self::IAKPRESS_QVAR] ) ) {
                $wp->query_vars[self::IAKPRESS_QVAR] = $_GET[self::IAKPRESS_QVAR];
            }
            
            if (!empty($wp->query_vars[self::IAKPRESS_QVAR])) {
                WP_IAKPress::getInstance()->getApp()->handleAndTerminate();
            }

            // iakpress-ui requests
            if ( ! empty( $_GET[self::IAKPRESS_UI_QVAR] ) ) {
                $wp->query_vars[self::IAKPRESS_UI_QVAR] = $_GET[self::IAKPRESS_UI_QVAR];
            }
            
            if (!empty($wp->query_vars[self::IAKPRESS_UI_QVAR])) {
                WP_IAKPress::getInstance()->getApp()->renderUI();
            }
        }

    

        /**
         * Render IAK Posts
         */
        public function renderShortcodeIAKPost($args) {
            extract(shortcode_atts(array(
                'id' => null
                ), $args));
            
            if (!is_null($id)) {
                IAKPressApp::getInstance()->bootKernel();
                
                return IAKFront::getInstance()->renderForm($id);
            } else {
                return WP_IAKPress::EMPTY_POST_ID_GIVEN;
            }
        }

        public function renderBlockIAKPost($args) { 
            $id = intval($args[Constants::IAKPOST_ID] ?? 0);
            if ($_SERVER["REQUEST_METHOD"] == "POST") { // ajax request : do not render form
                return "";
            }

            return '[iakpost id="'.$id. '"]';
        }


        public function renderBlockIAKField($args) { 
            $type = intval($args[Constants::IAKFIELD_TYPE] ?? 0);

            return "iakfield_type=".$type;
        }

        public function onUserLoggedIn($username, $user) {

        }

        public function onUserLogout($userId) {

        }

        public function pluginInstall()  {
        }
        
        public function pluginUpdate()  {
            $version = get_option(Constants::VERSION);
        
            $shouldUpdate = !($version === PluginInterface::VERSION);

            if ($shouldUpdate) {
                update_option(Constants::STATIC_URL, PluginInterface::getInstance()->getStaticUrl(), true);
                update_option(Constants::VERSION, PluginInterface::VERSION, true);
                                
                ApiKeysModel::getInstance()->createApiKeys();

                $this->clearCacheAndLogDirs();
            }
        }

        protected function clearCacheAndLogDirs()
        {
            $fsObject = new Filesystem();

            //remove cache and log dirs
            try {
                $dirs = array(
                    self::getCacheDir(),
                    self::getLogDir()
                );

                $fsObject->remove($dirs);

                return null;
            } catch (IOExceptionInterface $exception) {
                return "Error deleting directory at " . $exception->getPath();
            }
        }
        
        public function pluginUninstall()  {
            delete_option(Constants::STATIC_URL);
            delete_option(Constants::VERSION);
        }
    }

    endif;

define ('IAK_DEBUG', false);
/**
 * Returns the main instance of IAKPress to prevent the need to use globals.
 *
 * @return WP_IAKPress
 */
function iak_instance() {
    return WP_IAKPress::getInstance();
}

// Global for backwards compatibility.
$GLOBALS[WP_IAKPress::PLUGIN_PREFIX] = iak_instance();
/* EOF */
