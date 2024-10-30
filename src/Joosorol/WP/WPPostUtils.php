<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\WP;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAPostType\ContactPostType;
use App\Joosorol\IAKPress\IAModel\EntryStatus;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtilsInterface;
use App\Joosorol\IAKPress\IAPost\User;
use App\Joosorol\WP\IAModel\PostConfigModel;

class WPPostUtils extends PostUtilsInterface
{
    public function isAdmin() : bool {
        return is_admin();
    }
    
    public function getUserCanManage() {
        // for dev purpose
        if ($this->isRequestFromLocalhost()) {
            return true;
        }

        // ref -> https://codex.wordpress.org/Roles_and_Capabilities
        return  current_user_can('manage_options') ;
    }

    public function hasBlocks() {
        return function_exists( 'register_block_type' );
    }
    
    /**
     * Wordpress User
     */
    public function getCurrentUser() : ?User
    {
        if ($this->userLoggedIn()) {
            $user = wp_get_current_user();

            if ($user instanceof \WP_User) {
                $roles = $user->roles;
                $role = array_shift($roles);
    
                return new User($user->user_login, $user->user_email, true);
            }
        }


        return null;
    }


    public function getLocale() {
        return get_locale();
    }

    public function userLoggedIn()
    {
        return is_user_logged_in();
    }

    public function doGetRoles()
    {
        $wp_roles = new \WP_Roles();
        $roles = $wp_roles->get_names();

        return $roles;
    }

    public function updatePostMeta(int $postId, string $metaKey, $metaValue)
    {
        update_post_meta($postId, $metaKey, $metaValue);
    }

    public function getPostMeta(int $postId, string $key = '', bool $single = false)
    {
        return get_post_meta($postId, $key, $single);
    }

    public function deletePostMeta(int $postId, string $key)
    {
        delete_post_meta($postId, $key);
    }

    public function getPostById($id) {
        return \WP_Post::get_instance($id);
    }

    public function getPostBySlug($slug, $postType) {
        $query = new \WP_Query([
            "post_type" => $postType,
            "name" => $slug
        ]);
    
        return $query->have_posts() ? reset($query->posts) : null;
    }

    public function getCurrentTime() {
        return current_time('mysql');
    }

    public function deletePost(int $postId, bool $forceDelete = false)
    {
        wp_delete_post($postId, $forceDelete);
    }

    public function updatePost(array $formData)
    {
        return wp_update_post($formData);
    }

    public function updateUser(array $formData)
    {
        return wp_update_user($formData);
    }

    public function updateTermMeta(int $postId, string $metaKey, $metaValue)
    {
        update_term_meta($postId, $metaKey, $metaValue);
    }

    public function getTermMeta(int $postId, string $key = '', bool $single = false)
    {
        return get_term_meta($postId, $key, $single);
    }

    public function deleteTermMeta(int $postId, string $key)
    {
        delete_term_meta($postId, $key);
    }

    public function deleteTerm(int $postId, string $taxonomy)
    {
        wp_delete_term($postId, $taxonomy);
    }

    public function updateTerm(int $termId, string $taxonomy, array $formData)
    {
        wp_update_term($termId, $taxonomy, $formData);
    }

    public function getTermById($id, $taxonomy = null) {
        return \WP_Term::get_instance($id, $taxonomy);
    }

    public function getTerms(array $args) {
        return get_terms($args);
    }

    public function getPostConfigType($postId)
    {
        return $this->getPostMeta($postId, PostConfig::POST_CONFIG_TYPE, true);
    }

    public function setPostTerms(int $post_ID, string $taxonomy, $post_categories = array(), bool $append = false) {
        wp_set_post_terms($post_ID, $post_categories, $taxonomy, $append);
    }

    public function hasEntries($postId)
    {
        if (intval($postId) == 0) {
            return false;
        }

        $typeId = $this->getPostConfigType($postId);

        if (!empty($typeId)) {
            $parentTypeId = TemplateTypes::getParentTypeId($typeId);

            switch ($parentTypeId) {
                case TemplateTypes::FT_MODEL_GROUP:
                    return true;


                default:
                    return false;
            }
        }

        return false;
    }

    public function validatePublishData($formConfigType, array $data): bool
    {
        return true;
    }

    public function getPublishPostTypeConfig($formConfigType): array
    {
        $type = intval($formConfigType);

        switch ($type) {
            case TemplateTypes::FT_CONTACT_FORM:
                return (new ContactPostType())->toArray();

            default:
                return [];
        }
    }

    public function formatEntry(array $viewConfig, array $entry, $isArchive = false): array
    {
        $fields = $viewConfig[PostConfig::FIELDS];

        $modelConfig = $viewConfig[Constants::PARENT_MODEL];

        $formattedEntry = [];

        $formattedEntry[Option::ID] = $entry[Option::ID];
        $formattedEntry[Option::NAME] = $entry[Option::NAME];

        foreach ($fields as $name => $field) {
            $refId = $field[Option::ITEM_ID] ?? '';
            $fieldType = intval($field[Option::FIELD_TYPE]);

            if (FieldRenderType::getParentTypeId($fieldType) == FieldRenderType::SELECT_CONTENT_TYPE) {

                if (!$isArchive) {
                    $descTpl = $field[Constants::CONTENT] ?? '';

                    $params = array_merge(
                        $entry,
                        [
                            'post_title' => $modelConfig[PostConfig::POST_CONFIG_TITLE] ?? '',
                            'fields' => $modelConfig[PostConfig::FIELDS] ?? array(),
                            'entry' => $entry,
                            'desc_tpl' => $descTpl
                        ]
                    );

                    $default_message = PluginInterface::getInstance()->getTwig()->render('default_message.html.twig',  $params);
                    $params['default_message'] =  $default_message;

                    $content = PluginInterface::getInstance()->getTwig()->render('post-desc.html.twig',  $params);
                    $formattedEntry[$name] =  html_entity_decode($content);
                }
            } else if (isset($entry[$refId])) {
                $formattedEntry[$name] = $entry[$refId];
            }
        }

        // set required fields
        if (isset($entry[Constants::TITLE])) {
            $formattedEntry[Constants::TITLE] = $entry[Constants::TITLE];
        }

        if (isset($entry[Constants::PRODUCT_STOCK])) {
            $formattedEntry[Constants::PRODUCT_STOCK] = $entry[Constants::PRODUCT_STOCK];
        }

        if (isset($entry[Constants::PRODUCT_STOCK])) {
            $formattedEntry[Constants::PRODUCT_STOCK] = $entry[Constants::PRODUCT_STOCK];
        }

        $formattedEntry[Constants::PERMALINK] = get_post_permalink($entry[Option::ID]);

        return $formattedEntry;
    }

    public function formatEntries(array $viewConfig, array $entries): array
    {
        $formattedEntries = [];

        foreach ($entries as $k => $entry) {
            $formattedEntries[$k] = $this->formatEntry($viewConfig, $entry, true);
        }

        return $formattedEntries;
    }

    public function getBooleanVal($boolTtext)
    {
        $boolTtext = (string) $boolTtext;
        if (empty($boolTtext) || '0' === $boolTtext || 'false' === $boolTtext) {
            return false;
        }

        return true;
    }

    public function getPublicPostTypes()
    {
        $args = array(
            'public' => true,
        );

        $post_types = get_post_types($args, 'objects');

        $res = [];
        foreach ($post_types as $post_type_obj) {
            $labels = get_post_type_labels($post_type_obj);

            if ($post_type_obj->name != Constants::IA_POST_CONFIG_POST_TYPE) {
                $res[$post_type_obj->name] = $labels->name;
            }
        }

        return $res;
    }

    public function getOption(string $optionName, $default = false) {
        return get_option($optionName, $default);
    }

    public function updateOption(string $optionName, $optionValue)  {
        update_option($optionName, $optionValue, true );
    }

    public function setStatus(
                                int $entryId,
                                array $requestData) {
        $post = $this->getPostById($entryId);

        if ($post) {
            $statusId = $requestData[Option::STATUS_ID] ?? null;

            if ($statusId && EntryStatus::isValidStatus($statusId)) {
                $this->updatePost([
                    "ID" => $entryId,
                    "post_status" => $statusId
                ]);


                return $this->getPostById($entryId);
            }
        }

        return null;
    }

    public function countEntriesByStatusId(string $statusId) : int {
        global $wpdb;

        $totalCount = 0;
        if (EntryStatus::isValidStatus($statusId)) {

            $countQuery =  "SELECT COUNT(ID)as total FROM ". $wpdb->posts ." WHERE post_type=%s AND post_status=%s";

            $totalCount = $wpdb->get_var($wpdb->prepare(
                                                    $countQuery,
                                                    Constants::IA_GENERIC_ENTRY_POST_TYPE,
                                                    $statusId
                                                ));
        }
      
        return $totalCount;
    }

    public function fetchFormConfigById($formConfigId) {
        if (intval($formConfigId) != 0) {
            return PostConfigModel::getInstance()->fetchSingle($formConfigId);
        } else {
            $post_type =  get_query_var('post_type');
            if (!empty($post_type)) {
                $formConfig = PluginInterface::getInstance()->getCustomPostType($post_type);

                if (!is_null($formConfig)) {
                    return PostConfigModel::getInstance()->fetchSingle($formConfig[PostConfig::POST_CONFIG_ID]);
                }

                return $formConfig;
            }

            return null;
        }
    }

    public function fetchFormConfigByName($formName) {
        return PostConfigModel::getInstance()->fetchSingleByName($formName);
    }


    public function getPages() : array {
        $res = array();
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
          $res[$page->ID] = [
              Option::TITLE => $page->post_title,
              Option::LINK => get_page_link( $page->ID )
          ];
        }
        return $res;
    }

    public function getDataDir() : string {
        $data = wp_upload_dir();
       
        return $data["basedir"] ?? "";
    }

    public function getDataUrl() : string {
        $data = wp_upload_dir();
       
        return $data["baseurl"] ?? "";
    }

    protected function  getEncryptDecryptKey() : string {
        return sprintf("iak%s%s%s", DB_NAME, DB_USER, DB_PASSWORD);
    }

    public function getUsername($username) : string {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = $this->getUserBy(Option::EMAIL, $username);

            return $user ? $user->getUsername() : $username;
        }

        return $username;
    }
    
    public function signOn(string $username, string $password,  bool $remember = false) : ?User {

        if ($this->userLoggedIn()) {
            $user = $this->getCurrentUser();
        } else {

            $username = $this->getUsername($username);

            $credentials = [
                'user_login' => $username,
                'user_password' => $password,
                'remember' => $remember
            ];


            $user = wp_signon($credentials, true);

            if ($user instanceof \WP_User) {
                wp_set_current_user( $user->ID, $username );
                wp_set_auth_cookie( $user->ID, $remember, false );
                do_action( 'wp_login', $username );
            }
        }


        if ($user instanceof \WP_User) {
            return new User($user->user_login, $user->user_email, true);
        }

        return null;
    }

    public function getUserBy($field, $value) : ?User {
        $user = get_user_by($field, $value);

        if ($user instanceof \WP_User) {
            return new User($user->user_login, $user->user_email, true);
        }

        return null;
    }
}
