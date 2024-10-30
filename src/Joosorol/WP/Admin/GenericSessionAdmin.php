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
 * Description of GenericSessionAdmin
 *
 * @author bly
 */
class GenericSessionAdmin extends DefaultPostEntryAdmin
{    
    public function getName() : string {
        return Constants::IA_GENERIC_SESSION_POST_TYPE;
    }

    public function getPostType(): string
    {
        return Constants::IA_GENERIC_SESSION_POST_TYPE;
    }



    protected function doRegisterPostType()
    {
        $labels = [
            'name' => __('Session'),
            'singular_name' => __('Session'),
            'menu_name' => 'Sessions',
            'all_items' => 'Sessions',
            'view_item' => __('View Session'),
            'add_new_item' => __('Add New Session'),
            'add_new' => __('Add New'),
            'edit_item' => __('Edit Session'),
            'update_item' => __('Modify Session'),
            'search_items' => __('Search Session'),
            'not_found' => __('Not Found'),
            'not_found_in_trash' => __('Not Found in trash')
        ];

        $supports = array('title', 'editor');

        $args = array(
            'label' => 'Sessions',
            'labels' => $labels,
            'supports' => $supports,
            'menu_position' => 5,
            'show_ui' => true,
            'show_in_menu' => false,
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
