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
 *
 * @author bly
 */
class ApiKeysAdmin extends PostConfigAdmin
{
    const LIST = 'IAKConfig List';
    const EDIT_TEMPLATE = 'admin-form-edit.html.twig';
    const ADD_TEMPLATE = 'admin-form-add.html.twig';

    public function getPostType() : string {
        return Constants::IA_API_KEYS_POST_TYPE;
    }

    public function getName() : string {
        return Constants::IA_API_KEYS_POST_TYPE;
    }
	
	public function hasEntries($postId) {
		return false;
	}

    protected function doRegisterPostType()
    {
        $labels = array(
            'name' => _x('API Keys', 'Post Type General Name'),
            'singular_name' => _x('API Keys', 'Post Type Singular Name'),
            'menu_name' => __('API Keys'),
            'all_items' => __('API Keys'),
            'view_item' => __('View API Key'),
            'add_new_item' => __('Add New API Key'),
            'add_new' => __('Add'),
            'edit_item' => __('Edit API Key'),
            'update_item' => __('Modify API Key'),
            'search_items' => __('Search API Keys'),
            'not_found' => __('Not found'),
            'not_found_in_trash' => __('Not found in trash'),
        );

        $supports = array('');

        $args = array(
            'label' => __('API Keys'),
            'description' => __('API Keys'),
            'labels' => $labels,
            'supports' => $supports,
            'menu_position' => 5,
            'show_ui' => false,
            'show_in_menu' =>  Constants::IA_DASH_PAGE,
            'hierarchical' => true,
            'public' => false,
            'rewrite' => false,
            'rewrite' => array( 'slug' =>  $this->getPostType()),

            'capability_type' => 'post',
            'capabilities' => array(
                'create_posts' => 'do_not_allow',
            ),
            'map_meta_cap' => true // Set to `false`, if users are not allowed to edit/delete existing posts
        );

        register_post_type($this->getPostType() , $args);
    }
}