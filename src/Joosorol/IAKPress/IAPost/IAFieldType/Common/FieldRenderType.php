<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;


class FieldRenderType
{
    const BF_BUTTON_RENDER_TYPE = 'button';
    const BF_CHECKBOX_RENDER_TYPE = 'checkbox';
    const BF_COLOR_RENDER_TYPE = 'color';
    const BF_DATE_RENDER_TYPE = 'date';
    const BF_DATETIME_LOCAL_RENDER_TYPE = 'datetime-local';
    const BF_EMAIL_RENDER_TYPE = 'email';
    const BF_FILE_RENDER_TYPE = 'file';
    const BF_HIDDEN_RENDER_TYPE = 'hidden';
    const BF_IMAGE_RENDER_TYPE = 'image';
    const BF_MONTH_RENDER_TYPE = 'month';
    const BF_NUMBER_RENDER_TYPE = 'number';
    const BF_PASSWORD_RENDER_TYPE = 'password';
    const BF_RADIO_RENDER_TYPE = 'radio';
    const BF_RANGE_RENDER_TYPE = 'range';
    const BF_TEL_RENDER_TYPE = 'tel';
    const BF_TEXT_RENDER_TYPE = 'text';
    const BF_TIME_RENDER_TYPE = 'time';
    const BF_URL_RENDER_TYPE = 'url';
    const BF_WEEK_RENDER_TYPE = 'week';
    const BF_TEXTAREA_RENDER_TYPE = 'textarea';

    const BF_RENDER_IMAGE_TYPE = 'mediaselector';

    const SELECT_RENDER_TYPE = 'select';
    const LABEL_RENDER_TYPE = 'label';
    const POST_CONFIG_RENDER_TYPE = 'form';
    const LAYOUT_RENDER_TYPE = 'text';
    const CUSTOM_POST_RENDER_TYPE = 'text';
    const SLIDER_RENDER_TYPE = 'slider';
    const CONFIG_RENDER_TYPE = 'json';
    const YOUTUBE_RENDER_TYPE = 'youtube';

    const CHOICE_RENDER_TYPE = 'choice';
    const CHOICE_SETTINGS_RENDER_TYPE = 'choice_settings';
    const CHOICE_BF_CHECKBOX_RENDER_TYPE = 'checkbox';
    const CHOICE_CHECKBOX_GROUP_RENDER_TYPE = 'select';
    const CHOICE_RADIO_GROUP_RENDER_TYPE = 'select';
    const CHOICE_SELECT_RENDER_TYPE = 'select';
    const CHOICE_MULTI_SELECT_RENDER_TYPE = 'select';
    const CHOICE_PRODUCT_RENDER_TYPE = 'select';
    const CHOICE_CATEGORY_RENDER_TYPE = 'select';
    const CHOICE_DATA_LIST_RENDER_TYPE = 'select';


    const CHOICE_OPTION_RENDER_TYPE = 'option';

    // SelectBFType range 100-199
    const SELECT_BF_TYPE = 1;
    const BF_TEXT_TYPE = 100;
    const BF_EMAIL_TYPE = 101;
    const BF_PASSWORD_TYPE = 102;
    const BF_COLOR_TYPE = 103;
    const BF_TEL_TYPE = 104;
    const BF_TEXTAREA_TYPE = 105;
    const BF_URL_TYPE = 106;
    const BF_MEDIA_FILE_TYPE = 107;
    const BF_CHECKBOX_TYPE = 108;
    const BF_DATE_TYPE = 109;
    const BF_DATETIME_LOCAL_TYPE = 110;
    const BF_MONTH_TYPE = 111;
    const BF_NUMERIC_TYPE = 112;
    const BF_RANGE_TYPE = 113;
    const BF_TIME_TYPE = 114;
    const BF_WEEK_TYPE = 115;
    const BF_HIDDEN_TYPE = 116;
    const BF_INTEGER_TYPE = 117;
    const BF_SLUG_TYPE = 118;
    const BF_PARENT_QUIZ_ITEM_TYPE = 119;
    const BF_WEIGHT_TYPE = 120;
    const BF_DIMENSIONS_TYPE = 121;
    const BF_PRICE_TYPE = 122;
    const BF_SALE_PRICE_TYPE = 123;


    const BF_BOOKING_PERIOD_TYPE = 150;

    // SelectFileType range 200-299


    // SelectSliderType range 300-399
    const SELECT_SLIDER_TYPE = 3;
    const SLIDER_RANGE_TYPE = 300;
    const SLIDER_STEP_TYPE = 301;
    const SLIDER_FIXED_MIN_TYPE = 302;
    const SLIDER_FIXED_MAX_TYPE = 303;

    const SLIDER_RANGE_POST_CONFIG_TYPE = 304;
    const SLIDER_STEP_POST_CONFIG_TYPE = 305;
    const SLIDER_FIXED_MIN_POST_CONFIG_TYPE = 306;
    const SLIDER_FIXED_MAX_POST_CONFIG_TYPE = 307;

    // ButtonType range 400-499
    const FORM_BTN_RENDER_TYPE = 'button';
    const SELECT_FORM_BTN_TYPE = 4;
    const FORM_BTN_SUBMIT_TYPE = 400;
    const FORM_BTN_PREVIOUS_TYPE = 401;
    const FORM_BTN_NEXT_TYPE = 402;
    const FORM_BTN_RESET_TYPE = 403;
    const FORM_BTN_SEARCH_TYPE = 404;
    const FORM_BTN_LINK_TYPE = 405;
    const FORM_BTN_SIGN_UP_TYPE = 406;
    const FORM_BTN_LOG_IN_TYPE = 407;
    const FORM_BTN_RESET_PASSWORD_TYPE = 408;
    const FORM_BTN_CHANGE_PASSWORD_TYPE = 409;
    const FORM_BTN_MODIFY_PROFIL_TYPE = 410;


    // DecoratorType range 500-599
    const DECORATOR_RENDER_TYPE = 'decorator';
    const SELECT_DECORATOR_TYPE = 5;
    const DECORATOR_EMAIL_SUBJECT_TYPE = 500;
    const DECORATOR_SUPPORT_TOPIC_TYPE = 501;
    const DECORATOR_PRODUCT_ITEM_TYPE = 502;
    const DECORATOR_MENU_ITEM_TYPE = 503;
    const DECORATOR_IMAGE_ITEM_TYPE = 504;
    const DECORATOR_PHOTO_GALLERY_TYPE = 505;
    const DECORATOR_LINKED_PRODUCT_TYPE = 506;
    const DECORATOR_PRODUCT_VARIANT_TYPE = 507;

    const DECORATOR_PRODUCT_GENERAL_SECTION_TYPE = 508;
    const DECORATOR_PRODUCT_DESC_SECTION_TYPE = 509;
    const DECORATOR_PRODUCT_SHIPPING_SECTION_TYPE = 510;
    const DECORATOR_CUSTOM_LIST_ITEM_TYPE = 511;


    // CheckBoxType range 600-699
    const CHECKBOX_RENDER_TYPE = 'checkbox';
    const SELECT_CHECKBOX_TYPE = 6;
    const CHECKBOX_TYPE = 600;

    // PhotoGallery range 700-799
    const PHOTO_GALLERY_RENDER_TYPE = 'photogallery';
    const SELECT_PHOTO_GALLERY_TYPE = 7;
    const STANDARD_PHOTO_GALLERY_TYPE = 700;

    // ContentView range 800-899
    const CONTENT_VIEW_RENDER_TYPE = 'contentview';
    const SELECT_CONTENT_VIEW_TYPE = 8;
    const CONTENT_VIEW_LIST_VIEW_TYPE = 800;


    // RadioType range 900-999
    const PRODUCT_LIST_RENDER_TYPE = 'productlist';
    const SELECT_PRODUCT_LIST_TYPE = 9;
    const PRODUCT_LIST_TYPE = 900;


    // SelectBackendContentType range 1000-1099

    // SelectOptionType range 1100-1199
    const OPTION_RENDER_TYPE = 'select';
    const SELECT_OPTION_TYPE = 11;
    const OPTION_TYPE = 1100;
    const OPTION_SIMPLE_SELECT_TYPE = 1101;
    const OPTION_PARENT_FIELD_TYPE = 1102;
    const OPTION_SECTION_TYPE = 1103;
    const OPTION_SUB_OPTIONS_TYPE = 1104;
    const OPTION_GENERIC_MODEL_TYPE = 1105;
    const OPTION_SUB_GENERIC_MODEL_TYPE = 1106;
    const OPTION_GENERIC_ENTRY_TYPE = 1107;
    const OPTION_SMTP_API_TYPE = 1108;
    const OPTION_PAYMENT_API_TYPE = 1109;
    const OPTION_EMAIL_TYPE = 1110;
    const OPTION_ORDER_ITEM_TYPE = 1111;
    const OPTION_ITEM_SIZES_GROUP_TYPE = 1112;
    const OPTION_BLOG_POST_TYPE = 1113;
    const OPTION_POST_CONFIG_TYPE_TYPE = 1114;
    const OPTION_FIELD_CONFIG_TYPE = 1115;
    const OPTION_PRIMARY_CATEGORY_GROUP_TYPE = 1116;
    const OPTION_DATE_LOCALE_CODE_TYPE = 1117;
    const OPTION_CURRENCY_TYPE = 1118;
    const OPTION_CHOICE_GROUP_TYPE_TYPE = 1119;
    const OPTION_ORDER_BY_TYPE = 1120;
    const OPTION_ORDER_DIRECTION_TYPE = 1121;
    const OPTION_CHECKBOX_GROUP_TYPE = 1122;
    const OPTION_RADIO_GROUP_TYPE = 1123;
    const OPTION_SUB_CHOICE_GROUP_TYPE = 1124;
    const OPTION_THUMB_WIDTH_TYPE = 1125;
    const OPTION_OPTION_GROUP_TYPE = 1126;
    const OPTION_OPTION_GROUP_CHILD_TYPE = 1127;


    // SelectLayoutType range 1200-1299
    const SELECT_LAYOUT_TYPE = 12;
    const DEFAULT_POST_LAYOUT_TYPE = 1200;
    const BOOTSTRAP_HORIZONTAL_LAYOUT_TYPE = 1201;
    const LEFT_ALIGNED_LABELS_TYPE = 1202;
    const TOP_ALIGNED_LABELS_TYPE = 1203;
    const IA_ADMIN_LAYOUT_TYPE = 1205;
    const RIGHT_ALIGNED_LABELS_TYPE = 1206;
    const LABELS_WITHIN_INPUTS_TYPE = 1207;
    const BLOCK_LAYOUT_TYPE = 1208;
    const BOTTOM_ALIGNED_LABELS_TYPE = 1209;


    // SelectTextEditorType range 1300-1399
    const STEPPER_BUTTON_RENDER_TYPE = 'stepperbtn';
    const SELECT_STEPPER_BUTTON_TYPE = 13;
    const STEPPER_BUTTON_BTN_NEXT_TYPE = 1300;
    const STEPPER_BUTTON_BTN_PREVIOUS_TYPE = 1301;


    // SelectContainerSectionType range 1400-1499
    const CONTAINER_RENDER_TYPE = 'containerfield';
    const SELECT_CONTAINER_TYPE = 14;
    const CONTAINER_BASIC_SECTION_TYPE = 1400;
    const CONTAINER_SIGN_UP_SECTION_TYPE = 1401;


    // SelectActionType range 1500-1599
    const ACTION_RENDER_TYPE = 'action';
    const SELECT_ACTION_TYPE = 15;
    const ACTION_MAIL_NOTIFICATION_TYPE = 1500;
    const ACTION_THANK_YOU_SCREEN_TYPE = 1501;
    const ACTION_QUIZ_FEEDBACK_TYPE = 1502;

    const ACTION_SIGN_UP_ADMIN_NOTIFICATION_TYPE = 1550;
    const ACTION_SIGN_UP_USER_NOTIFICATION_TYPE = 1551;
    const ACTION_RESET_PASSWORD_NOTIFICATION_TYPE = 1552;
    const ACTION_ORDER_CONFIRMATION_TYPE = 1553;
    const ACTION_BOOKING_CONFIRMATION_TYPE = 1554;
    const ACTION_SMS_NOTIFICATION_TYPE = 1555;


    // SelectEntryActionType range 1600-1699
    const ENTRY_ACTION_RENDER_TYPE = 'entryaction';
    const SELECT_ENTRY_ACTION_TYPE = 16;
    const ENTRY_ACTION_CREATED_TYPE = 1600;
    const ENTRY_ACTION_UPDATED_TYPE = 1601;
    const ENTRY_ACTION_DELETED_TYPE = 1602;


    // SelectSmartFieldType range 1700-1799
    const SELECT_SF_TYPE = 17;
    const SF_GENERIC_ENTRY_TITLE_TYPE = 1700;
    const SF_GENERIC_MODEL_TITLE_TYPE = 1701;
    const SF_POST_CONFIG_TITLE_TYPE = 1702;

    const SF_RENDER_TYPE = 'sf';


    // SelectApiConfigType range 1800-1899
    const SELECT_API_CONFIG_TYPE = 18;
    const GOOGLE_CLIENT_TYPE = 1800;
    const FACEBOOK_API_TYPE = 1801;
    const AWS_S3_API_TYPE = 1802;
    const PAYPAL_API_TYPE = 1803;
    const STRIPE_API_TYPE = 1804;
    const SMTP_API_TYPE = 1805;

    // SelectDisplayBlockType range 1900-1999
    const DISPLAY_BLOCK_RENDER_TYPE = 'dblock';
    const SELECT_DISPLAY_BLOCK_TYPE = 19;
    const DISPLAY_BLOCK_NAVBAR = 1900;
    const DISPLAY_BLOCK_HERO_HEADER = 1901;
    const DISPLAY_BLOCK_CONTENT_SLIDER = 1902;
    const DISPLAY_BLOCK_HTML_CONTENT = 1903;

    // SelectChoiceType range 2000-2099
    const SELECT_CHOICE_TYPE = 20;
    const CHOICE_IMAGE_LIST = 2000;
    const CHOICE_CHECKBOX_GROUP_TYPE = 2001;
    const CHOICE_RADIO_GROUP_TYPE = 2002;
    const CHOICE_SINGLE_SELECT_TYPE = 2003;
    const CHOICE_LAYOUT_TYPE = 2004;
    const CHOICE_PRODUCT_LIST = 2005;
    const CHOICE_MENU_LIST = 2006;
    const CHOICE_CATEGORY_LIST = 2008;
    const CHOICE_TAG_LIST = 2009;
    const CHOICE_OPTION_GROUP_LIST = 2010;
    const CHOICE_CUSTOM_LIST = 2011;

    const CHOICE_CASCADING_CHECKBOX_GROUP_TYPE = 2050;
    const CHOICE_CASCADING_RADIO_GROUP_TYPE = 2051;
    const CHOICE_CASCADING_SINGLE_SELECT_TYPE = 2052;


    const TAXONOMY_RENDER_TYPE = 'taxonomy';
    // SelectChoiceType range 2100-2199
    const SELECT_TAXONOMY_TYPE = 21;
    const TAXONOMY_CATEGORY_TYPE = 2100;
    const TAXONOMY_NAV_MENU_TYPE = 2101;
    const TAXONOMY_BRAND_TYPE = 2102;


    const MEDIA_RENDER_TYPE = 'media';
    // SelectMediaType range 2200-2299
    const SELECT_MEDIA_TYPE = 22;
    const MEDIA_IMAGE_TYPE = 2200;
    const MEDIA_UPLOAD_IMAGE_TYPE = 2201;
    const MEDIA_UPLOAD_FILE_TYPE = 2202;
    const MEDIA_BARCODE_SCANNER_TYPE = 2203;



    const CONTENT_RENDER_TYPE = 'content';
    // SelectTextEditorType range 2300-2399
    const SELECT_CONTENT_TYPE = 23;
    const CONTENT_BASIC_TYPE = 2300;
    const CONTENT_RICH_TEXT = 2301;
    const CONTENT_HTML = 2302;
    const CONTENT_BREAK_LINE_TYPE = 2304;
    const CONTENT_POST_CONFIG_TYPE = 2305;
    const CONTENT_INPUT_PARAGRAPH = 2306;


     // SelectCollectionType range 2400-2499

    // range 2500-2599
    const API_CONFIG_RENDER_TYPE = 'apiconfig';

    // SelectQuizType range 2600-2699
    const QUESTION_RENDER_TYPE = 'question';
    const SELECT_QUESTION_TYPE = 26;
    const MULTI_CHOICE_QUESTION_TYPE = 2600;
    const SINGLE_CHOICE_QUESTION_TYPE = 2601;

    // SelectReferenceFieldType range 2700-2799

    // SelectStoreSectionType range 2800-2899
    const STORE_SECTION_RENDER_TYPE = 'storesection';
    const SELECT_STORE_SECTION_TYPE = 28;
    const STORE_SECTION_ADDRESS = 2800;
    const STORE_SECTION_SHIPPING = 2801;

    // SelectLayoutType range 2900-2999

    // CartButtonType range 3000-3099
    const CART_BTN_RENDER_TYPE = 'cartbutton';
    const SELECT_CART_BTN_TYPE = 30;
    const CART_BTN_TYPE = 3000;


    const COLOR_RENDER_TYPE = 'color';
    // SelectColorType range 3100-3199
    const SELECT_COLOR_TYPE = 31;
    const COLOR_PICKER_TYPE = 3100;
    const COLOR_PALETTE_TYPE = 3101;
      
    // SelectChoiceOptionType range 0-10
    const SELECT_CHOICE_OPTION_TYPE = 0;
    const CHOICE_OPTION_TEXT = 1;
    const CHOICE_OPTION_FILE = 2;


    public static function getParentTypeId($fieldTypeId)
    {
        $fieldTypeId = intval($fieldTypeId);

        if ($fieldTypeId < 100) {
            return $fieldTypeId;
        } else {
            return floor($fieldTypeId / 100);
        }
    }

    public static function isBasicChoiceType($type)  : bool {
        $fieldType = intval($type);
    
        return $fieldType < self::CHOICE_CASCADING_CHECKBOX_GROUP_TYPE && $fieldType >= self::CHOICE_IMAGE_LIST;
    }

    public static function isSection($type)  : bool {
        $parentFieldType = self::getParentTypeId($type);
    
        return $parentFieldType == FieldRenderType::SELECT_CONTAINER_TYPE;
    }


    public static function isCascadingChoiceType($type) : bool {
        $fieldType = intval($type);
    
        return $fieldType < self::CHOICE_CASCADING_CHECKBOX_GROUP_TYPE + 50 && $fieldType >= self::CHOICE_CASCADING_CHECKBOX_GROUP_TYPE;
    }
}
