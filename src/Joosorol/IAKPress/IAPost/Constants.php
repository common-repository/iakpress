<?php

/*
* This file is part of the IAKPress package.
*
* (c) IAKPress <contact@iakpress.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace App\Joosorol\IAKPress\IAPost;

/**
 * class Constans
 */
class Constants {
  const PLUGIN_PREFIX = 'iakpress';
  const IAKPRESS_QVAR = 'iakpressq';
  const IAKPRESS_UI_QVAR = 'iakpressuiq';

  const IAK_SESSION_ID = 'iak_session_id';

  const DEFAULT_LIMIT = 60;
  const POST_CONFIG_LIMIT = 8;
  const ATTACHMENT_LIMIT = 5;

  const IA_ADMIN_PAGE_NAME = 'iakpress.com';
  const IA_ADMIN_ROUTE_PREFIX = '/iakpress.com/admin';
  const IA_ADMIN_DASHBOARD_URI = '/iakpress.com/admin/dashboard';

  const ENTRIES_POST_TYPE_PREFIX = 'iae';
  const FIELDS_POST_TYPE_PREFIX = 'iaf';
  const CHOICE_GROUPS_POST_TYPE_PREFIX = 'iag';
  const CHOICES_POST_TYPE_PREFIX = 'iac';

  const IA_POST_CONFIG_POST_TYPE = 'iapost';
  const IA_PUBLISH_POST_TYPE = 'iapublish';

  const IAK_POST_TYPE = 'iak_post_type';
  
  const IA_ADMIN_POST_CONFIG_POST_TYPE = 'iaadminpost';
  const IA_LICENCE_POST_TYPE = 'ialicense';
  const IA_PRODUCT_LICENCE_POST_TYPE = 'iaproductlicense';
  const IA_CONTACT_POST_TYPE = 'iacontact';
  const IA_NAV_MENU_POST_TYPE = 'iakmenu';
  const IAK_POST_ID_FORM_POST_TYPE = 'iakpostidform';

  const IA_HOME_PAGE_POST_TYPE = 'iahomepage';

  const PARENT_NODE = 'parent_node';

  const IA_MODULE_FORMS_POST_TYPE = 'iak_forms';

  const IA_POST_ENTRIES_POST_TYPE = 'iablockentries';
  const IA_CUSTOM_POST_TYPE = 'iacustompost';

  const IA_GENERAL_STYLE_POST_TYPE = 'iageneralstyle';
  const IA_ADVANCED_STYLE_POST_TYPE = 'iaadvancedstyle';
  const IA_STEPS_STYLE_POST_TYPE = 'iastepsstyle';
  const IA_COLUMN2_STYLE_TYPE = 'iac2style';
  const IA_COLUMN3_STYLE_TYPE = 'iac3style';
  const IA_COLUMN4_STYLE_TYPE = 'iac4style';


  const IA_CPT_BASIC_SETTINGS = 'iacptbasic';
  const IA_CPT_LABELS = 'iacptlabels';
  const IA_CPT_ADAVANCED_SETTINGS = 'iacptadvanced';

  const IA_TAXO_BASIC_SETTINGS = 'iataxobasic';
  const IA_TAXO_LABELS = 'iataxolabels';
  const IA_TAXO_ADAVANCED_SETTINGS = 'iataxoadvanced';

  const IA_LIST_GENERAL_STYLE_TYPE = 'ialistgeneralstyle';
  const IA_LIST_ITEM_STYLE_TYPE = 'ialistitemstyle';


  const IA_FIELD_STYLE_TYPE = 'iafieldstyle';

  const IAK_CONTENT = 'iak_content';
  const IAK_CONTENT_CONFIG = 'iak_content_config';
  const FIELD_CONTENT_EDITOR = 'field_content_editor';

  const POST_ID = 'post_id';
  const META_KEY = 'meta_key';
  const META_VALUE = 'meta_value';
  
  const IA_TPL_BASE_POST_TYPE = 'iatplbase';
  const IA_TPL_CUSTOM_POST_TYPE = 'iatplcustom';
  const IA_TPL_CONTACT_POST_TYPE = 'iatplcontact';

  const IA_GENERIC_ENTRY_POST_TYPE = 'iagenericentry';
  const IA_GENERIC_MODEL_POST_TYPE = 'iagenericmodel';
  const IA_GENERIC_SESSION_POST_TYPE = 'iagenericsession';
  const IA_SIGN_UP_POST_TYPE = 'iasignup';
  const IA_CHOICE_GROUP_FIELD_POST_TYPE = 'iachoicegroupfield';
  const IA_ATTACHMENT_POST_TYPE = 'attachment';

  const ERR_MSG = 'err_msg';
  const ERR_TYPE = 'err_type';
  const RESPONSE_ERRORS = 'errors';

  const IA_POST_VIEW_POST_TYPE = 'iapostview';

  const IA_CUSTOM_PRODUCT_POST_TYPE = 'iacustomprod';
  const IA_CUSTOM_POST_POST_TYPE = 'iacustompost';

  const IA_CPT_POST_TYPE = 'iacpt';


  const IA_API_KEYS_POST_TYPE = 'iaapikeys';


  const PAGE_POST_TYPE = 'page';
  const POST_POST_TYPE = 'post';


  const IA_ENTRY_POST_TYPE = 'iaentry';

  const DASH_DELIMITER = '-';
  const UNDERSCORE_DELIMITER = '_';

  const ENTRIES = 'entries';
  const VIEWS = 'views';

  const ENTRY = 'entry';
  const ENTRY_ID = 'id';
  const ENTRY_SLUG = 'slug';
  const CHILDREN = 'children';
  const TOP = 'top';
  const COUNT = 'count';
  const TOTAL_NEW = 'total_new';
  const TOTAL = 'total';
  const TOTAL_PAGES = 'total_pages';
  const PAGE_NUMBER = 'page_number';
  const ITEMS_PER_PAGE = 'items_per_page';

  const NULL_ENTRY_ID = 0;

  const FRONT_BUNDLE_NAME = 'front_bundle_name';
  const MODULE_NAME = 'module_name';
  const DOM_ELEMENT_ID = 'dom_element_id';
  const PAGE_TYPE = 'page_type';
  const IAKPRESS_MODULE_URL = 'iakpress_module_url';

  const EDITOR_PAGE_TYPE = 'editor_page';
  const BLOCK_PAGE_TYPE = 'block_block';
  const FRONT_PAGE_TYPE = 'front_page';

  const POST_TYPE = 'post_type';
  const IS_THEME = 'is_theme';
  const CONTEXT = 'context';
  const THEME = 'theme';
  const IS_SINGLE_VIEW = 'is_single_view';
  const IS_CPT = 'is_cpt';

  const MODEL_ID = 'model_id';
  const PNODE_ID = 'pnode_id';
  const FETCH_ALL = 'fetch_all';
  const TEMPLATE_ID = 'template_id';
  const SUBMIT_BTN_TYPE = 'submit_btn_type';
  const SUBMIT_BTN_NAME = 'submit_btn_name';
  const SUBMIT_BTN_STEP = 'submit_btn_step';
  const PREV_ENTRY = 'prev_entry';
  const NEXT_ENTRY = 'next_entry';

  const IP_ADDRESS = 'ip_address';
  const USER_AGENT = 'user_agent';
  const SESSION_VALUE = 'session_value';
  const SESSION_EXPIRY = 'session_expiry';

  const TOTAL_PRICE = "total_price";
  const TRANSACTION_ID = "transaction_id";
  const ORDER_ID = "order_id";
  const ORDER_ITEM_ID = "order_item_id";
  const ORDER_ITEM_NAME = "order_item_name";
  const ORDER_ITEM_QTY = "order_item_qty";
  const ORDER_ITEM_PRICE = "order_item_price";

  const ERROR_DUP_VALUE = 'dup_value';
  const ERROR_EMAIL_TAKEN = 'email_taken';


  const PRODUCT_PRICE_HT = 'price_ht';
  const PRODUCT_PRICE_HT_LABEL = 'Price';

  const PRODUCT_STOCK = 'stock';

  const PERMALINK = 'permalink';

  const MEDIA_NAME = 'resource_name';

  const IAK_TINYMCE_PLUGIN_URL = 'iak_tinymce_plugin_url';

  const IA_FIELD_POST_TYPE = 'iafield';
  const IAK_PRESS_TC_BUTTON = 'iakpress_tc_button';

  const IA_PHOTO_GALLERY_POST_TYPE = 'iaphotogallery';
  const IA_LINKED_PRODUCT_POST_TYPE = 'ialinkedprod';
  const IA_PRODUCT_VARIANT_POST_TYPE = 'iaprodvariant';
  const IA_ORDER_ITEM_POST_TYPE = 'iaorderitem';
  const IA_ORDER_POST_TYPE = 'iaorder';

  const IA_RESPONSE = 'iaresponse';
  const IA_CONTEXT = 'iacontext';

  const IAKPRESS_ICON = 'iakpress_icon';
  const IAKPRESS_ICON_FILE = 'css/images/iakpress/02.png';
 
  const IAKFIELDCONTENT_JS = 'iakpress_iakfieldcontent';
  const IAKFIELDCONTENT_JS_FILE = 'js/iakfieldcontent.js';

  const FRONT_JS = 'iakpress';
  const FRONT_JS_FILE = 'js/iakfront.bundle.js';

  const SERVER_JS = 'iakserver_admin';
  const SERVER_JS_FILE = 'js/iakserver.bundle.js';

  const IAK_COMMON_JS = 'iakpress_common';
  const IAK_COMMON_JS_FILE = 'js/iakcommon.bundle.js';

  const IAK_BLOCKS_MAIN_JS = 'iakpress_blocks_main';
  const IAK_BLOCKS_RUNTIME_JS = 'iakpress_blocks_runtime';

  const SERVER_FRONT_JS = 'iakserver_front';
  const SERVER_FRONT_JS_FILE = 'js/iakserverfront.bundle.js';

  const VENDOR_JS = 'iakpress_vendor';
  const VENDOR_JS_FILE = 'js/iakvendor.bundle.js';
  
  const VENDOR_REACTDOM_JS = 'iakpress_vendor_reactdom';
  const VENDOR_REACTDOM_JS_FILE = 'js/react-dom.bundle.js';

  const IAKSERVER_VENDOR_REACTDOM_JS = 'iakserver_vendor_reactdom';
  const IAKSERVER_VENDOR_REACTDOM_JS_FILE = 'js/react-dom.bundle.js';

  const FEATHER_LIGHT_JS  = 'iakpress_feather_light';
  const FEATHER_LIGHT_JS_FILE  = 'vendor/featherlight/js/featherlight.min.js';

  const IAKSERVER_FEATHER_LIGHT_JS  = 'iakserver_feather_light';
  const IAKSERVER_FEATHER_LIGHT_JS_FILE  = 'vendor/featherlight/js/featherlight.min.js';

  const IAKPOST_BLOCK_NAME = 'iakpress/iakpost';
  const IAKPOST_SHORTCODE_NAME = 'iakpost';

  const ADMIN_CSS = 'iakpress_admin_css';
  const ADMIN_CSS_FILE = 'css/style.css';

  const FRONT_CSS = 'iakpress_grid_css';
  const FRONT_CSS_FILE = 'css/front.css';

  const BOOTSTRAP_CSS = 'iakpress_bootstrap_css';
  const BOOTSTRAP_CSS_FILE = 'vendor/bootstrap/css/bootstrap.min.css';

  //const IA_DASH_PAGE = 'edit.php?post_type=iapost';
  const IA_DASH_PAGE = 'iakpress-dash';

  const IA_FORMS_PAGE = 'iak_forms';
  const IA_ENTRIES_PAGE = 'iak_entries';
  const IA_NOTIFICATIONS_PAGE = 'iak_notifications';
  const IA_CUSTOM_PRODUCTS_PAGE = 'iak_custom_products';
  const IA_CUSTOM_POSTS_PAGE = 'iak_custom_posts';

  const SUBSCRIPTION_PAGE_NAME = 'iakpress-dash';
  const ADD_ONS_PAGE_NAME = 'iakpress-addons';

  const IAKPRESS = 'iakpress';

  const IAK_POST_PARENT = 'iak_post_parent';
  const IAK_MODEL_ID = 'iak_model_id';

  const LOCALE = 'locale';
  const DATE_LOCALE = 'date_locale';
  const USER_CAN_MANAGE = 'user_can_manage';

  const LICENSE_TYPE = 'license_type';
  const LICENSE_REF = 'license_ref';
  const LICENSE_EXP = 'license_exp';
  const LICENSE_LIFETIME = 'license_lifetime';
  const LICENSE_PCODE = 'license_pcode';
  const LDATA = 'ldata';
  
  const IAKPRESS_KEY = 'iak_key';
  const IAKPRESS_PCODE = 'iak_pcode';
  const IAKPRESS_LICENSE_EXP = 'iak_license_exp';

  const IAKPRESS_SECURE_KEY = 'iak_secure_key';

  const IAKPRESS_SIGN_UP_FORM_ID = 'iak_signup_form_id';
  const IAKPRESS_SESSION_FORM_ID = 'iak_session_form_id';
  const IAKPRESS_ORDER_FORM_ID = 'iak_order_form_id';


  const IAKFRONT_HEADER_LABEL = 'Header';
  const IAKFRONT_HEADER_ID = 'iakfront_header_id';
  const IAKFRONT_HEADER_TITLE = 'iakfront_header_title';

  const IAKFRONT_NAVBAR_CLASS_LABEL = 'Navbar Class';
  const IAKFRONT_NAVBAR_CLASS = 'iakfront_navbar_class';

  const IAKFRONT_FOOTER_LABEL = 'Footer';
  const IAKFRONT_FOOTER_ID = 'iakfront_footer_id';
  const IAKFRONT_FOOTER_TITLE = 'iakfront_footer_title';

  const IAKPOST_ID = 'iakpost_id';
  const IAKPOST_ID_LABEL = 'Form';

  const IAKFIELD_TYPE = 'iakfield_type';
  const IAKFIELD_TYPE_LABEL = 'IAKField';

  const MEDIA_EDITOR = 'wp_media';
  const CONTENT_EDITOR = 'wp_editor';

  const IA_DASH_PAGE_SLUG = 'dashboard_slug';
  const IA_FORMS_PAGE_SLUG = 'forms_slug';
  const EDIT_LOCK = '_edit_lock';
  const EDIT_LAST = '_edit_last';
  
  const START = 'start';
  const LIMIT = 'limit';
  const ORDER_BY = 'order_by';
  const ORDER_BY_DIRECTION = 'order_by_direction';

  const STATIC_URL = 'iakpress_static_url';
  const VERSION = 'iakpress_version';
  const PRO_VERSION = 'iakpresspro_version';

  const PRO_STATIC_URL = 'iakpresspro_static_url';

  const POST_CONFIG_PARENT_ID = 'parent_id';
  const PARENT_MODEL = 'parent_model';
  const POST_CONFIG_TYPE = 'p_config_type';

  const ID = 'id';
  const FORM_NAME = 'form_name';
  const FORM_TYPE = 'form_type';

  const DEFAULT_ID_VALUE = PHP_INT_MAX ;

  const IS_PRO_VERSION = 'is_pro_version';
  const IS_WP = 'is_wp';

  const TITLE = 'title';
  const TITLE_LABEL = 'Label';
  const CONTENT = 'content';
  const CONTENT_EXCERPT = 'content_excerpt';
  const NAME = 'name';
  const INTRO = 'intro';
  const CREATED_AT = 'created_at';
  const CREATED_AT_GMT = 'created_at_gmt';
  const UPDATED_AT = 'updated_at';
  const UPDATED_AT_GMT = 'updated_at_gmt';
  const USER_ID = 'user_id';
  const FIELD_ID = 'field_id';
  const MENU_ORDER = 'menu_order';
  const INTERNAL_ID = 'internal_id';

  const QUIZ_RESULT = 'quiz_result';
  const FRONT_ACTIONS = 'front_actions';
  const MAIL_NOTIF_ERRORS = 'mail_notif_errors';
  const NB_CORRECT = 'nb_correct';
  const NB_TOTAL = 'nb_total';
  const NB_WRONG = 'nb_wrong';

  const IS_SINGULAR = 'is_singular';
  const IS_ARCHIVE = 'is_archive';
  const IS_HOME = 'is_home';
  const IS_SEARCH = 'is_search';
  const SINGULAR_TEMPLATE = 'singular_template';
  const ARCHIVE_TEMPLATE = 'archive_template';
  const SEARCH_TEMPLATE = 'search_template';

  const ADMIN_EMAIL = 'admin_email';

  const NB_QUESTIONS = 'nb_questions';
  const FIRST_NAV_FIELD_ID = 'first_nav_field_id';
  const FIRST_NAV_FIELD_NAME = 'first_nav_field_name';
  const CART_FIELD_NAME = 'cart_field_name';
  const HAS_SLIDER = 'has_slider';
  const HAS_CART = 'has_cart';

  const MEDIA_ID = 'media_id';

  const FPATH_MEDIA_ID = 'fpath_media_id';
  const FPATH_FILE = 'fpath_file';
  const FPATH_THUMBNAIL = 'fpath_thumbnail';
  const FPATH_LARGE = 'fpath_large';

  const FILE = "file";


  const NOT_IMPLEMENTED_ERROR = "Function is not implemented.";

  const IAKREQUEST = 'iakrequest';
  const POST_IDS = 'post_ids';

  const PASSWORD_REGEX = '(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})';

  const DUMMY_PASSWORD = 'XXX';

  /**
   * Constructor.
   */
  private function __construct() {
  }

  static function getAllPages() : array {
    return [
      self::IA_DASH_PAGE_SLUG => self::IA_DASH_PAGE,
      self::IA_FORMS_PAGE_SLUG => self::IA_FORMS_PAGE,
    ];
  }
}

/* EOF */
