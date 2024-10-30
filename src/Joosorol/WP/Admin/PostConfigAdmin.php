<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\Admin;

use App\Joosorol\IAKPress\IAModel\EntryStatus;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\IAKPress\IAPost\ClientConfig;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;

/**
 *
 * @author bly
 */
class PostConfigAdmin extends DefaultPostConfigAdmin
{
    const LIST = 'IAK Posts';
    const EDIT_TEMPLATE = 'admin-form-edit.html.twig';
    const ADD_TEMPLATE = 'admin-form-add.html.twig';

    const ENTRIES = 'entries';
    const ENTRIES_LABEL = 'Entries';

    const SHORT_CODES = 'shortcodes';
    const SHORT_CODES_LABEL = 'Shortcodes';

    public function getPostType() : string {
        return Constants::IA_POST_CONFIG_POST_TYPE;
    }

    public function getName() : string {
        return Constants::IA_POST_CONFIG_POST_TYPE;
    }

    protected function doSetInputPostId($val) {
        parent::doSetInputPostId($val);

        $this->setCurrentPostConfigId($val);
    }


    protected function doInit() {
        parent::doInit();

        if ($this->getInputPostType() == $this->getPostType()) {
            add_filter( 'get_sample_permalink_html', array($this, 'hidePermalink'));
            
            add_action( 'admin_menu', function () {
                remove_meta_box( 'submitdiv', $this->getPostType(), 'side' );
            } );

            add_filter('get_user_option_screen_layout_'.$this->getPostType(),  function () {
                return 1;
            });

            add_action( 'after_wp_tiny_mce',  array($this, 'iakTinymcePlugin') );

            add_action('admin_head', array($this, 'hideAddButton'));

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

        }
    }

    protected function getMenuName() {
        $coutEntries = PostUtils::getInstance()->countEntriesByStatusId(EntryStatus::STATUS_UNREAD);

        return sprintf('IAKPress [ %s ]', $coutEntries > 0 ? $coutEntries : '');
    }
    
    protected function doRegisterPostType()
    {
        $labels = array(
            'name' => _x('Forms', 'Post Type General Name'),
            'singular_name' => _x('Form', 'Post Type Singular Name'),
            'menu_name' => $this->getMenuName(),
            'all_items' => __('My Forms'),
            'view_item' => __('View Form'),
            'add_new_item' => ' ',
            'add_new' => __('New Form'),
            'edit_item' => __('Edit Form'),
            'update_item' => __('Modify Form'),
            'search_items' => __('Search Forms'),
            'not_found' => __('Not found'),
            'not_found_in_trash' => __('Not found in trash')
        );

        $args = array(
            'label' => __('Form'),
            'description' => __('All Forms'),
            'labels' => $labels,
            'supports' => array(''),
            'menu_position' => 50,
            'show_ui' => false,
            'menu_icon' =>  PluginInterface::getInstance()->getPluginIconUrl(),
            'hierarchical' => true,
            'public' => true,
            'rewrite' => false,
            'rewrite' => array( 'slug' =>  $this->getPostType()),
        );

        register_post_type($this->getPostType() , $args);
    }

    public function getAddTemplate() {
        return self::ADD_TEMPLATE;
    }

    public function getEditTemplate() {
        return self::EDIT_TEMPLATE;
    }

    public function getIAKTinymcePluginUrl() {
        return PluginInterface::getInstance()->getIAKTinymcePluginUrl();
    }

    public function iakTinymcePlugin() {
        echo '<script src="'. $this->getIAKTinymcePluginUrl().'"></script>';
    }

    public function hideAddButton() {
        if (is_admin()) {
            $screen = get_current_screen();
            if (!is_null($screen) && $screen->base != 'edit') {
                echo '
                    <style>
                        .wp-heading-inline, .page-title-action {
                            display: none !important;
                        }
                    </style>
                ';
            }
        }
    }
    
    protected function buildPreviewUrl() {
        $formConfig = $this->getCurrentFormConfig();

        return sprintf("%s&relativeUrl=/%s/form/%s/frender", 
                        PluginInterface::getInstance()->getAdminAjaxUrl(),
                        PluginInterface::getInstance()->getPluginPrefix(),
                        $formConfig[PostConfig::POST_CONFIG_ID]     
                    );
    }

    public function removePostTypeSupport() {
        remove_post_type_support( 'post', 'custom-fields' );
    }


    public function hidePermalink() {
        return '';
    }

    public function getColumnHeaders($columns) {
        $columns = [
            'title' => __('Form Title'),
            self::SHORT_CODES => self::SHORT_CODES_LABEL,
            'date' => $columns['date']
        ];

        // returning new columns
        return $columns;
    }

    public function columnData($column, $postId) {
        // setup our return text
	    $output = '';
	
	    switch( $column ) {
		    case self::SHORT_CODES:
                $output = sprintf('[iakpost id=%s]', $postId);
			    break;
	    }
	
	    // echo the output
	    echo $output;
    }
}
