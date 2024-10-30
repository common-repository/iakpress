<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\Admin;

use App\Joosorol\IAKPress\IAPost\Constants;

/**
 * Description of FieldConfigAdmin
 *
 * @author bly
 */
class FieldConfigAdmin extends DefaultPostEntryAdmin
{
    const POST_CONFIG_NAME = 'iapostfield';
    const POST_TYPE = Constants::IA_FIELD_POST_TYPE;

    public function __construct() {
    }

    public function getName() : string {
        return self::POST_CONFIG_NAME;
    }

    public function getPostType(): string
    {
        return Constants::IA_FIELD_POST_TYPE;
    }

    protected function doInit(): void {
        parent::doInit();

        if ($this->getInputPostType() == $this->getPostType()) {
            add_action('init', array($this, 'registerPostType'));      
        }
    }


    protected function doRegisterPostType(): void
    {
        $postType = $this->getPostType();

        $labels = array(
            'name' => _x('Field List', 'Field Type General Name'),
            'singular_name' => _x('Field', 'Field Type Singular Name'),
            'menu_name' => __('Field'),
            'all_items' => __('Field List'),
            'view_item' => __('View Field'),
            'add_new_item' => __('Add New Field'),
            'add_new' => __('Add'),
            'edit_item' => __('Edit Field'),
            'update_item' => __('Modify Field'),
            'search_items' => __('Search Field'),
            'not_found' => __('Not found'),
            'not_found_in_trash' => __('Not found in trash'),
        );

        $supports = array('editor');

        $args = array(
            'label' => __('Field List'),
            'description' => __('Field List'),
            'labels' => $labels,
            'supports' => $supports,
            'menu_position' => 5,
            'show_ui' => false,
            'show_in_menu' => false,
            'hierarchical' => true,
            'public' => false,
            'has_archive' => false,
            'capability_type' => 'post',
            'capabilities' => array(
                 'create_posts' => 'do_not_allow',
             ),
            'map_meta_cap' => true,
            'rewrite' => array( 'slug' =>  $postType),
        );

        register_post_type($postType , $args);
    }
}
