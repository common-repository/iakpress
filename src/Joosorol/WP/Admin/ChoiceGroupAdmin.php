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
class ChoiceGroupAdmin extends PostConfigAdmin
{
    const LIST = 'IAKChoices';
    const EDIT_TEMPLATE = 'admin-form-edit.html.twig';
    const ADD_TEMPLATE = 'admin-form-add.html.twig';

    public function getPostType() : string {
        return Constants::IA_GENERIC_MODEL_POST_TYPE;
    }

    public function getName() : string {
        return Constants::IA_GENERIC_MODEL_POST_TYPE;
    }
	
	public function hasEntries($postId) {
		return true;
	}

    protected function doRegisterPostType(): void
    {
        $labels = array(
            'name' => _x('Choice Group', 'Post Type General Name'),
            'singular_name' => _x('Choice Group', 'Post Type Singular Name'),
            'menu_name' => __('Choice Group'),
            'all_items' => __('Choice Groups'),
            'view_item' => __('View Choice Group'),
            'add_new_item' => __('Add New Choice Group'),
            'add_new' => __('Add'),
            'edit_item' => __('Edit Choice Group'),
            'update_item' => __('Modify Choice Group'),
            'search_items' => __('Search Choice Group'),
            'not_found' => __('Not found'),
            'not_found_in_trash' => __('Not found in trash'),
        );

        $supports = array('title');

        $args = array(
            'label' => __('Choice Group'),
            'description' => __('Choice Groups'),
            'labels' => $labels,
            'supports' => $supports,
            'menu_position' => 5,
            'show_ui' => false,
            'show_in_menu' =>  Constants::IA_DASH_PAGE,
            'hierarchical' => true,
            'public' => false,
            'capability_type' => 'post',
            'capabilities' => array(
                'create_posts' => 'do_not_allow',
            ),
            'map_meta_cap' => true,
            'rewrite' => array( 'slug' =>  $this->getPostType()),
        );


        register_post_type($this->getPostType() , $args);
    }
}