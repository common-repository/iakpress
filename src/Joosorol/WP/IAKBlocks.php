<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\PluginInterface;

/**
 * Description of IAKPressApp
 *
 * @author bly
 */
class IAKBlocks
{
    private static $instance;


	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new IAKBlocks();
		}
	}

    /**
	 * The Constructor.
	 */
	private function __construct() {
		add_action( 'wp_loaded', array( $this, 'enqueueEditorAssets' ), 9999 );
	}

    public function enqueueEditorAssets() {
        if( !is_admin() ){
			return;
		}

        $page = filter_input(INPUT_GET, 'page');
        if ($page == Constants::SUBSCRIPTION_PAGE_NAME) {
            return;
        }

        global $pagenow;

        if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
            wp_enqueue_script(
                Constants::IAK_COMMON_JS,
                PluginInterface::getInstance()->getAssets()[Constants::IAK_COMMON_JS],
                array(),
                PluginInterface::VERSION,
                false
            );
    
    
            $jsPath = PluginInterface::getInstance()->getStaticUrl();
            $blocksPath = PluginInterface::getInstance()->getStaticUrl() . '/blocks/';
            $cssPath = PluginInterface::getInstance()->getStaticUrl() . '/css/';
    
            wp_add_inline_script(
                Constants::IAK_COMMON_JS,
                "
                var iakpress_js_public_path = \"$jsPath\";
                var iakpress_css_public_path = \"$cssPath\";
                var iakpress_blocks_url = \"$blocksPath\";
    
                var iakpaths = {
                    js_public_path:  \"$jsPath\",
                    css_public_path: \"$cssPath\",
                    blocks_url: \"$blocksPath\",
                };",
                "before"
            );
    
            wp_enqueue_script(
                Constants::IAK_BLOCKS_RUNTIME_JS,
                PluginInterface::getInstance()->getAssets()[Constants::IAK_BLOCKS_RUNTIME_JS],
                array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', Constants::IAK_COMMON_JS),
                PluginInterface::VERSION,
                false
            );
    
            wp_enqueue_script(
                Constants::IAK_BLOCKS_MAIN_JS,
                PluginInterface::getInstance()->getAssets()[Constants::IAK_BLOCKS_MAIN_JS],
                array(Constants::IAK_BLOCKS_RUNTIME_JS),
                PluginInterface::VERSION,
                false
            );
        }
    }
}