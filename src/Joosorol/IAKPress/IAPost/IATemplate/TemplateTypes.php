<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\PostConfig;

class TemplateTypes {
    // Page PostTemplate range 100-199
    const FT_FORM_GROUP = 1;
    const FT_CONTACT_FORM = 100;
    const FT_ADVANCED_FORM = 101;
    const FT_PRODUCT_LIST_VIEW_FORM = 102;
    const FT_CUSTOM_LIST_VIEW_FORM = 103;

    // Global Forms should be created on plugin activation
    const FT_SIGN_UP_FORM = 104;
    const FT_SESSION_FORM = 105;
    const FT_ORDER_FORM = 106;

    // Gallery PostTemplate range 200-299
    const FT_GALLERY_GROUP = 2;
    const FT_PHOTO_GALLERY = 200;
    const FT_PRODUCT_GALLERY = 201;


    // Model PostTemplate range 300-399
    const FT_MODEL_GROUP = 3;
    const FT_MODEL_SIMPLE_LIST = 300;
    const FT_MODEL_SIMPLE_LIST_WITH_IMAGES = 301;
    const FT_MODEL_TAG_LIST = 302;
    const FT_MODEL_SIMPLE_PRODUCT_LIST = 303;
    const FT_MODEL_PRODUCT_LIST = 304;
    const FT_MODEL_OPTION_GROUP_LIST = 305;
    const FT_MODEL_CATEGORY_LIST = 306;
    const FT_MODEL_CUSTOM_LIST = 307;
    const FT_MODEL_HIERARCHICAL_LIST = 308;
    const FT_MODEL_HIERARCHICAL_LIST_WITH_IMAGES = 309;


    // ServiceConfig PostTemplate range 400-499
    const FT_API_KEYS_GROUP = 4;

    const FT_SMTP_API = 405;
    const FT_PAYPAL_API = 406;
    const FT_STRIPE_API = 407;
    const FT_GOOGLE_CLIENT = 408;
    const FT_YOUTUBE_API = 409;


    // Custom Post Type range 500-599
 

    // View PostTemplate range 600-699
    const FT_VIEW_GROUP = 6;
    const FT_PRODUCT_VIEW = 601;
    const FT_QUIZ_VIEW = 602;
    const FT_BLOG_POST_VIEW = 603;

    /**
     * Constructor
     */
    private function __construct()
    {
       
    }

    public static function getParentTypeId($typeId)
    {
        return floor(intval($typeId) / 100);
    }

    public static function isForm($typeId) {
        return self::getParentTypeId($typeId) == self::FT_FORM_GROUP;
    }

    public static function isSimpleContactForm($typeId) {
        return intval($typeId) == self::FT_CONTACT_FORM;
    }


    public static function isModel($typeId) {
        return self::getParentTypeId($typeId) == self::FT_MODEL_GROUP;
    }

    public static function isGallery($typeId) {
        return self::getParentTypeId($typeId) == self::FT_GALLERY_GROUP;
    }

    public static function isView($typeId) {
        return self::getParentTypeId($typeId) == self::FT_VIEW_GROUP;
    }

    public static function isCustomPostType($typeId) {
        $theTypeId = intval($typeId);

        return $theTypeId == self::FT_MODEL_CUSTOM_LIST || $theTypeId === self::FT_MODEL_PRODUCT_LIST;
    }

    public static function isCustomListingPage($typeId) {
        $theTypeId = intval($typeId);

        return $theTypeId == self::FT_PRODUCT_LIST_VIEW_FORM || $theTypeId === self::FT_CUSTOM_LIST_VIEW_FORM;
    }

    public static function isTaxonomy($typeId) {
        $theTypeId = intval($typeId);

        return $theTypeId == self::FT_MODEL_CATEGORY_LIST ||
                $theTypeId === self::FT_MODEL_TAG_LIST ||
                $theTypeId == self::FT_MODEL_OPTION_GROUP_LIST;
    }

    public static function isSignUpType($typeId) {
        $theTypeId = intval($typeId);

        return $theTypeId == self::FT_SIGN_UP_FORM;
    }

    public static function isOrderType($typeId) {
        $theTypeId = intval($typeId);

        return $theTypeId == self::FT_ORDER_FORM;
    }

    public static function isSessionType($typeId) {
        $theTypeId = intval($typeId);

        return $theTypeId == self::FT_SESSION_FORM;
    }

    public static function isTreeModel($typeId) {
        $theTypeId = intval($typeId);
    
        return $theTypeId === self::FT_MODEL_HIERARCHICAL_LIST ||
               $theTypeId ===  self::FT_MODEL_HIERARCHICAL_LIST_WITH_IMAGES;
    }

    public static function isGlobalForm($typeId) {
        $theTypeId = intval($typeId);
    
        return  $theTypeId == self::FT_SIGN_UP_FORM 
        || $theTypeId == self::FT_SESSION_FORM 
        || $theTypeId == self::FT_ORDER_FORM;
    }


    public static function getMetaQueryByGroup($group) {
        switch(intval($group)) {
            case TemplateTypes::FT_FORM_GROUP:
            return TemplateTypes::getFormGroupMetaQuery();

            case TemplateTypes::FT_MODEL_GROUP:
            return TemplateTypes::getModelGroupMetaQuery();

            case TemplateTypes::FT_VIEW_GROUP:
            return TemplateTypes::getViewGroupMetaQuery();

            case TemplateTypes::FT_GALLERY_GROUP:
            return TemplateTypes::getGalleryGroupMetaQuery();

            default:
            return array(
                'relation' => 'OR',
                array(
                    'key' => PostConfig::POST_CONFIG_TYPE,
                    'value' => TemplateTypes::FT_CONTACT_FORM
                ),
                array(
                    'key' => PostConfig::POST_CONFIG_TYPE,
                    'value' => TemplateTypes::FT_ADVANCED_FORM
                ),
                array(
                    'key' => PostConfig::POST_CONFIG_TYPE,
                    'value' => TemplateTypes::FT_PRODUCT_LIST_VIEW_FORM
                ),
                array(
                    'key' => PostConfig::POST_CONFIG_TYPE,
                    'value' => TemplateTypes::FT_CUSTOM_LIST_VIEW_FORM
                ),
                array(
                    'key' => PostConfig::POST_CONFIG_TYPE,
                    'value' => TemplateTypes::FT_PHOTO_GALLERY
                ),
                array(
                    'key' => PostConfig::POST_CONFIG_TYPE,
                    'value' => TemplateTypes::FT_PRODUCT_GALLERY
                )
            );
        }
    }

    public static function getFormGroupMetaQuery() {
        return array(
            'relation' => 'OR',
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_CONTACT_FORM
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_ADVANCED_FORM
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_PRODUCT_LIST_VIEW_FORM
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_CUSTOM_LIST_VIEW_FORM
            )
        );
    }

    public static function getGalleryGroupMetaQuery() {
        return array(
            'relation' => 'OR',
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_PHOTO_GALLERY
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_PRODUCT_GALLERY
            )
        );
    }

    public static function getModelGroupMetaQuery() {
        return array(
            'relation' => 'OR',
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_SIMPLE_LIST
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_SIMPLE_LIST_WITH_IMAGES
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_TAG_LIST
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_CATEGORY_LIST
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_OPTION_GROUP_LIST
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_PRODUCT_LIST
            )
        );
    }

    public static function getPageGroupMetaQuery() {
        return array(
            'relation' => 'OR',
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_CUSTOM_LIST
            )
        );
    }

    public static function getViewGroupMetaQuery() {
        return array(
            'relation' => 'OR',
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_PRODUCT_VIEW
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_QUIZ_VIEW
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_BLOG_POST_VIEW
            )
        );
    }


    public static function getCPTMetaQuery() {
        return array(
            'relation' => 'OR',
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_PRODUCT_LIST
            ),
            array(
                'key' => PostConfig::POST_CONFIG_TYPE,
                'value' => TemplateTypes::FT_MODEL_CUSTOM_LIST
            )
        );
    }
}