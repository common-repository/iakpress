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

/**
 * Description of FormEntryAdmin
 *
 * @author bly
 */
class FormEntryAdmin extends DefaultPostEntryAdmin
{
    const LIST_SLUG = Constants::IA_ENTRIES_PAGE;
    const EDIT_TEMPLATE = 'admin-entry-edit.html.twig';

    const POST_CONFIG_ID_META_KEY = 'form_id';
    const POST_CONFIG_ID_META_LABEL = 'Post ID';

    const NONCE_ACTION = 'iak_nonce_action';
    const NONCE_NAME = 'iak_nonce_name';

    const NOT_VALID_QUERY_STRING_KEY = 'iak_invalid_form';
    const ERROR_QUERY_STRING_KEY = 'iak_error_str';

    //const NOT_EXISTS_QUERY_STRING_KEY = 'iak_not_exists';

    const DELIMITER = "_";

    
    public function getName() : string {
        return Constants::IA_ENTRIES_PAGE;
    }

    public function getPostType(): string
    {
        return Constants::IA_GENERIC_ENTRY_POST_TYPE;
    }



    protected function doRegisterPostType()
    {
        $labels = [
            'name' => __('Form Entry'),
            'singular_name' => __('Form Entry'),
            'menu_name' => 'Form Entries',
            'all_items' => 'Form Entries',
            'view_item' => __('View Form Entry'),
            'add_new_item' => __('Add New Form Entry'),
            'add_new' => __('Add New'),
            'edit_item' => __('Edit Form Entry'),
            'update_item' => __('Modify Form Entry'),
            'search_items' => __('Search Form Entry'),
            'not_found' => __('Not Found'),
            'not_found_in_trash' => __('Not Found in trash')
        ];

        $supports = array('title', 'editor');

        $args = array(
            'label' => 'Form Entries',
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

        foreach(EntryStatus::STATUSES as $key => $label) {
            register_post_status( $key , array(
                'label'                     => $label,
                'public'                    => true,
                'post_type'                 => array( $this->getPostType() ), // Define one or more post types the status can be applied to.
                'show_in_admin_all_list'    => false,
                'show_in_admin_status_list' => false,
                'show_in_metabox_dropdown'  => false,
                'show_in_inline_dropdown'   => false
            ) );
        }
    }
}
