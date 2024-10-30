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
use App\Joosorol\WP\IAModel\ChoiceGroupModel;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\IAKPress\IAPost\PostConfig;


/**
 * Description of CPTAdmin
 *
 * @author bly
 */
class CPTAdmin extends DefaultPostEntryAdmin
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

    const IAK_VALUES = 'iak_values';
    const IAK_ERRORS = 'iak_errors';


    
    public function getPostType(): string
    {
        return Constants::IA_CPT_POST_TYPE;
    }

    public function getName() : string {
        return Constants::IA_CPT_POST_TYPE;
    }



    protected function doRegisterPostType()
    {
         // register custom post types
         $entries = ChoiceGroupModel::getInstance()->fetchCPTList();
         foreach ($entries as $formConfig) {
             $this->registerCPT($formConfig);
             PluginInterface::getInstance()->addCustomPostType($formConfig);
         }
    }

    protected function registerCPT(array $formConfig) {
        $settings = $formConfig[PostConfig::POST_SETTINGS] ?? array();
        $cptType = intval ($formConfig[Option::TYPE] ?? 0);
        $cptName =  $settings[Option::CPT_NAME] ?? '';
        $cptLabel =  $formConfig[PostConfig::POST_CONFIG_TITLE] ?? '';
        $cptSingularLabel =  $cptLabel;
        $cptViewId = intval($settings[Option::CPT_VIEW_ID] ?? 0);

        if (!empty($cptName) && !empty($cptLabel) && !empty($cptSingularLabel)) {
            $labels = array_merge(
                [
                    'name' => $cptLabel,
                    'singular_name' => $cptSingularLabel,
                    'menu_name' => $cptLabel,
                    'all_items' => $cptLabel,
                    'view_item' => sprintf('View %s', $cptSingularLabel),
                    'add_new_item' => sprintf('Add New %s', $cptSingularLabel),
                    'add_new' => __('Add New'),
                    'edit_item' => sprintf('Edit %s', $cptSingularLabel),
                    'update_item' => sprintf('Modify %s', $cptSingularLabel),
                    'search_items' => sprintf('Search %s', $cptSingularLabel),
                    'not_found' => __('Not Found'),
                    'not_found_in_trash' => __('Not Found in trash')
                ]
            );
        
            $args = array_merge(
                [
                    'label' => $cptLabel,
                    'labels' => $labels,
                    'menu_position' => 5,
                    'show_ui' => false,
                    'show_in_menu' => false,
                    'hierarchical' => false,
                    'public' => true,
                    'has_archive'  => true,
                    'show_in_rest' => true, // Important ! for gutenberg editor should be true
                    'rewrite' => array( 'slug' =>  $cptName)
                ]
            );

    
            register_post_type($cptName , $args);

            // register categories taxonomy
            $taxonomySlug =  ChoiceGroupModel::getInstance()->buildCategoriesTaxonomySlug($cptName);
            $this->registerTaxonomy($taxonomySlug, $cptName, true);

           
            if ($cptType === TemplateTypes::FT_MODEL_PRODUCT_LIST) {
                // register tags taxonomy
                $taxonomySlug =  ChoiceGroupModel::getInstance()->buildTagsTaxonomySlug($cptName);
                $this->registerTaxonomy($taxonomySlug, $cptName, false);


                // register optionsgroup taxonomy
                $taxonomySlug =  ChoiceGroupModel::getInstance()->buildOptionGroupsTaxonomySlug($cptName);
                $this->registerTaxonomy($taxonomySlug, $cptName, false);
             }
        }
    }

    protected function registerTaxonomy(string $taxonomy, string $postType, $isHierarchical = false) {
        $labels =  array_merge(
            [
                'name' => $taxonomy,
                'singular_name' => $taxonomy,
            ]
        );
    
    
        $args = array_merge(

            [
                'labels' => $labels
            ]
        );
    
        register_taxonomy($taxonomy , [$postType], $args);
    }


    protected function doRegisterShortCodes() {
    }
}
