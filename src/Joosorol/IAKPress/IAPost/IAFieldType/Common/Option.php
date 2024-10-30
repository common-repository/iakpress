<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;

use App\Joosorol\IAKPress\IALabel\FieldLabels;

class Option  extends BaseOption {
    const TYPE = 'type';
    const FIELD_TYPE = 'field_type';
    const DECORATOR_TYPE = 'decorator_type';
    const BLOCK_NAME = 'block_name';
    const READ_ONLY = 'read_only';
    const MODEL_TYPE = 'model_type';
    const MODEL_ID = 'model_id';
    const SUB_MODEL_ID = 'sub_model_id';
    const HIERARCHY_LEVEL = 'h_lvl';
    const HEIGHT = "height";
    const NAV_MENU_ID = 'menu_id';
    const TRIGGER_TYPE = 'tigger_type';
    const IMG = 'img';
    const COLOR = 'color';

    const HEADING_TAG = 'heading_tag';

    const HEADING_TEXT = 'heading_text';

    const IMAGE_SIZE_TYPE = 'size_type';

    const IMAGE_OPACITY = 'opacity';

    const POST_PERMALINK = 'permalink';
    const POST_EDIT_LINK = 'editlink';

    const BG_COLOR = 'bg_color';
    const BG_COLOR_LABEL = 'BG Color';

    const FILE_PATH = 'fpath';

    const FEATURED_VIDEO_PATH = 'vpath';

    const WEIGHT = 'weight';
    const WEIGHT_LABEL = 'Weight';

    const DIMENSIONS = 'dimensions';

    const ACTION_URL = 'action_url';

    const MEDIA_PATH = 'rpath';
    
    const ICON_CLASS = 'icon_class';

	const IMAGE_THUMBNAIL_PATH = 'fpath_thumbnail';

    const IMAGE_FULL_PATH = 'fpath_full';

    const FEATURED = 'featured';

    const IMAGE_MEDIUM_PATH = 'fpath_medium';
    const IMAGE_LARGE_PATH = 'fpath_large';

    const THUMB_PATH = 'thumb';
    
    const PARENT_FIELD = 'parent_field';
    const LINK_IMG = 'link_img';

    const BG_IMG = 'bg_img';
    const BG_IMG_LABEL = 'BG Image';

    const MENU_ORDER = 'menu_order';

    const SCORE_VALUE = 'score_value';

    const PRICE_VALUE = 'price_value';


    const NAV_MENU_ID_LABEL = 'Data set';

    const CHOICE_TYPE = 'choice_type';

    const CHOICE_SUB_FORM = 'choice_sub_form';

    const CONTENT_TYPE = 'content_type';

    const CONTENT_ID = 'content_id';
    const CONTENT_TITLE = 'content_title';
    const CONTENT_BODY = 'content_body';
    const CONTENT_NAME = 'content_name';

    const CONTENT = 'content';

    const DESCRIPTION = 'desc';

    const SHORT_DESCRIPTION = 'short_desc';

    const TEMPLATE = 'template';

    const OPTION_TYPE = FieldRenderType::OPTION_TYPE;
    const OPTION_SECTION_TYPE = FieldRenderType::OPTION_SECTION_TYPE;
    const OPTION_GENERIC_MODEL_TYPE = FieldRenderType::OPTION_GENERIC_MODEL_TYPE;
    const OPTION_GENERIC_ENTRY_TYPE = FieldRenderType::OPTION_GENERIC_ENTRY_TYPE;
    
    const OPTION_ARRAY_NAME_PREFIX = '_';

    const HIDE_LABEL = 'hide_label';
    const DISABLED = 'disabled';
    const HELP = 'help';
    const LABEL = 'label';
    const LONG_LABEL = 'longlabel';
    const REQUIRED = 'required';
    const READONLY = 'readonly';
    const TRIM = 'trim';
    const PLACEHOLDER = 'placeholder';

    const TRUE_VALUE = 'true';
    const TRUE_LABEL = 'True';

    const FALSE_VALUE = 'false';
    const FALSE_LABEL = 'False';

    const MAX_LENGTH = 'max_len';

    const PATTERN = 'pattern';

    const YES ="yes";
    const NO = "no";


    const MIN_LENGTH = 'min_len';

    const MIN_MAX_LENGTH = 'min_max_len';

    const MIN_MAX_CHOICES = 'min_max_choices';

    const ROW_CLASS = 'r_class';
    const ROW_STYLE = 'r_style';
    const LABEL_CLASS = 'l_class';
    const ROWS = 'rows';

    const LABEL_STYLE = 'l_style';
    
    const INPUTGROUP_CLASS = 'ig_class';
    const LABELGROUP_CLASS = 'lg_class';


    const INPUTGROUP_STYLE = 'ig_style';
    const INPUT_CLASS = 'i_class';
    const INPUT_STYLE = 'i_style';


    const SECTION_INPUT_CLASS = 'si_class';
    const SECTION_LABEL_CLASS = 'sl_class';
    const SECTION_ROW_CLASS = 'sr_class';

    const RENDER_TYPE = 'render_type';
    const OPTIONS = 'options';
    const SUB_OPTIONS = 'sub_options';
    const DEFAULT_STYLE = 'd_style';
    const VALUE = 'value';
    const VALUE_LABEL = 'Value';

    const DEFAULT_VALUE = 'default_value';
    const DEFAULT_VALUE_LABEL = 'Default value';

    const DEFAULT_LABEL = 'default_label';
    const NAME = 'name';
    const SHORT_NAME = 'short_name';
    const ID = 'id';
    const ULID = 'ulid';
    const TITLE = 'title';
    const LINK = "link";
    const SUB_TITLE = 'sub_title';
    const DESC = 'desc';
    const SHORT_DESC = 'short_desc';
    const DATALIST = 'datalist';

    const TITLE_LABEL = 'Title';
    const SUB_TITLE_LABEL = 'Sub title';

    const PRICE = 'price';
    const PRICE_LABEL = 'Price';

    const QTY = 'qty';

    const SLUG = 'slug';
    const EMAIL = 'email';
    const PARENT = 'parent';
    const DEFAULT_FIELD_SECTION = 'default_field_section';

    const PASSWORD = 'password';
    const NEW_PASSWORD = 'new_password';
    const CONFIRM_PASSWORD = 'confirm_password';
    const REMEMBER_ME = 'remember_me';

    const HELP_CLASS = 'h_class';

    const ERROR_CLASS = 'e_class';

    const SUCCESS_CLASS = 's_class';

    const INFO_CLASS = 'info_class';

    const SUCCESS_MSG = 'success_msg';

    const CSS_CLASS = "CSS class(es)";

    const INFO_MSG = 'info_msg';

    const ERROR_MSG = 'error_msg';
    const FORMAT_MSG = 'format_msg';

    const LINK_TARGET = 'target';

    const BEFORE_TEXT = 'before_text';

    const AFTER_TEXT = 'after_text';
    
    const CHAR_COUNT = 'char_count';

    const IAK_SCORE = 'iak_score';


    const CORRECT = 'correct';
    const VALID = 'valid';

    const QUESTION_NAME = 'q_name';

    const QUESTION_TYPE = 'q_type';

    const ANSWER_OPTION = 'answer_opt';

    const SCORE = 'score';

    const MIN_SCORE = 'min_score';

    const RATE_RANGE = 'rate_range';

    const MAX_SCORE = 'max_score';

    const IS_VALID = 'is_valid';

    const C_VALUE = 'c_val';

    const WRONG = 'wrong';

    const PARENT_ID = 'parent_id';

    const STATUS_ID = 'status_id';
    const STATUS_MSG = 'status_msg';
    const STATUS_DATE = 'status_date';
    const STATUS_LIST = 'status_list';

    const PARENT_NAME = 'parent_name';
    const TEMPLATE_ID = 'template_id';
    const DELETE = 'del';
    const HIDE = 'hide';
    const DELETABLE = 'deletable';
    const DATA = 'data';
    const ATTRS = 'attrs';
    const POST_CONFIG_TITLE = 'title';
    const POST_CONFIG_TYPE = 'type';
    const POST_CONFIG_LAYOUT = 'layout';

    const SKU = 'sku';

    const EXTERNAL_URL = 'external_url';

    const EXTERNAL_ID = 'external_id';

    const ITEM_ID = 'item_id';

    const GROUP_ID = 'group_id';
    const OPTION_ID = 'option_id';

    const OPTION_NAME = 'opt_name';

    const OPTION_LONG_NAME = 'opt_long_name';

    const OPTION_PRICE = 'option_price';

    const PARENT_ITEM_ID = 'p_item_id';

    const ITEM_TYPE = 'item_type';

    const PRODUCT_TYPE = 'prod_type';
	
	const PRODUCT_NAME = 'prod_name';
    
	const DISABLE_PRODUCT = 'prod_disabled';
    const REGULAR_PRODUCT_PRICE = 'r_price';

    const PLEASE_WAIT = 'please_wait';

    const SALE_PRODUCT_PRICE = 's_price';

    const IS_HIERARCHICAL  ="is_hierarchical";

    const CPT_NAME = 'cpt_name';
    const CPT_TAXONOMY = 'cpt_taxonomy';
    const CPT_ARCHIVE_LINK = 'cpt_archive_link';

    const CATEGORY_DEPTH = 'cat_depth';

    const PRIMARY_CATEGORY_GROUP = 'p_group';

    const SECONDARY_CATEGORY_GROUP = 's_group';

    const TERTIARY_CATEGORY_GROUP = 't_group';

    const TAG_GROUP = 'tag_group';

    const CPT_LABEL = 'cpt_label';

    const CPT_VIEW_ID = 'cpt_view_id';
    const CPT_LIST_ID = 'cpt_list_id';
    const CPT_LIST_SLUG = 'cpt_list_slug';

    const CPT_SINGULAR_LABEL = 'cpt_singular_label';
        
    const CPT_POST_TYPES = 'cpt_post_types';
    
    const POST_CONFIG_BG_COLOR = 'bg_color';

    const TEXT_COLOR = 'text_color';
    const ITEMS_TEXT_COLOR = 'it_text_color';

    const ITEMS_HOVER_BG_COLOR = 'it_hover_bg_color';

    const ITEMS_HOVER_TEXT_COLOR = 'it_hover_text_color';

    const SELECTED_ITEM_BG_COLOR = 'it_selected_bg_color';

    const SELECTED_ITEM_TEXT_COLOR = 'it_selected_text_color';


    const CHECKMARK_BG_COLOR = 'it_checkmark_bg_color';

    const CHECKMARK_BORDER_COLOR = 'it_checkmark_b_color';

    const POST_CONFIG_BG_IMG = 'bg_img';

    const POST_CONFIG_BG_OPACITY = 'bg_opacity';
    
    const POST_CONFIG_BG_MIN_HEIGHT = 'bg_min_h';

    const TOP_POSITION  = 't_position';

    const LEFT_POSITION  = 'l_position';

    const IMG_MIN_HEIGHT = 'img_min_h';

    const IMG_OPACITY = 'img_opacity';

    const POST_CONFIG_BODY_CLASS = 'body_class';

    const COLUMN_WIDTH = 'width';

    const COLUMN_HEIGHT = 'height';

    const ITEMS_MAIN_COLUMN = 'it_main_col';
    
    const ITEMS_HEADER_COLUMN = 'it_header_col';

    const ITEMS_FOOTER_COLUMN = 'it_footer_col';

    const REF_TITLE = 'ref_title';
	
    const REF_TYPE = 'ref_type';
	
	const REF_ARCHIVE_VIEW_ID = 'p_ref_lview_id';
	
	const REF_SINGLE_VIEW_ID = 'p_ref_sview_id';

    const IAK_FIELD = 'iak_field';
	
	const IAK_POST = 'iak_post';

    const ITEMS_CONTAINER_WIDTH = 'it_c_width';

    const ENABLE_SHOPPING_CART = 'enable_cart';
    
    const LOGIN_REQUIRED = 'login_required';

    const ITEMS_PER_ROW   =   'it_per_row';

    const ITEMS_THUMB_WIDTH   =   'it_thumb_width';

    const ITEMS_THUMB_SIZE   =   'it_thumb_size';

    const ITEMS_PER_PAGE   =   'it_per_page';

    const ITEMS_ORDER_BY   =   'it_order_by';

    const ITEMS_ORDER_DIRECTION   =   'it_order_dir';

    const COLUMNS_COUNT   =   'col_count';

    const MSG_BODY =  'content';

    const IMG_HEIGHT = 'height';
    const IMG_HEIGHT_LABEL = 'Height';


    const IMAGE_PATH = 'img_url';

    const TARGET_URL = 'target_url';

    const DOWNLOAD_URL = 'download_url';


    const IMG_WIDTH = 'width';

    const ITEMS_IMG_OPACITY = 'it_img_opacity';
    
    const ITEMS_MIN_HEIGHT = 'it_min_height';

    const ITEMS_MIN_WIDTH = 'it_min_width';

    const ITEMS_BODY_CLASS = 'it_body_class';
    const ITEMS_MAIN_CLASS = 'it_main_class';

    const ITEMS_BG_COLOR = 'it_bg_color';

    const ITEMS_BORDER_COLOR = 'it_b_color';

    const ITEMS_LAYOUT = 'it_layout';

    const FIELD_LAYOUT = 'f_layout';

    const ITEMS_CLASS = 'it_class';

    const ITEMS_SELECTED_CLASS = 'it_sclass';

    const ITEMS_IMAGE_CLASS = 'it_iclass';


    const ITEMS_LABEL_CLASS = 'it_lclass';
    const ITEMS_CHECKMARK_CLASS = 'it_cclass';

    const ITEMS_HIDE_CHECKMARK = 'it_hide_check';
    const ITEMS_HIDE_LABEL = 'it_hide_label';

    const ITEMS_ENABLE_PURCHASE = 'it_enable_purchase';

    const ITEMS_STYLE = 'it_style';


    const ITEMS_LINK_CLASS = 'it_link_class';
    
    const REVERSE = '_reverse';

    const META = 'meta';
    const ENTRY_TITLE = 'entry_title';
    const ENTRY_CONTENT = 'entry_content';

    const ALLOW_ADD_FIELDS = 'allow_add_fields';

    const CHOICE_FORM = 'choice_form';
    const CHOICE_GROUP = 'choice_group';
    
    const POST_TYPE = 'post_type';

    const POST_CONFIG_ID = 'id';
    const POST_CONFIG_DEMO_URL = 'form_demo_url';
    const FIELD_WIDTH = 'field_width';
    const LABEL_WIDTH = 'l_width';
    const ROW_WIDTH = 'r_width';
    const LIST_ITEMS_PER_ROW = 'li_width';
    
    const PAGE_NAME = 'page_name';
    const PAGE_NAME_LABEL = 'Page';

    const SECTION_NAME = 'section_name';

    const CSS_NAME = 'css_name';

    const CHECK_GROUP_1 = 'check_group1';

    const RANGE_MIN = 'min';
    const RANGE_MAX = 'max';
    CONST RANGE_STEP = 'step';
    const RANGE = 'range';
    const UNIT = 'unit';
    const RANGE_RANGE = 'range';
    const RANGE_MIN_DEFAULT = 'min_default';
    const RANGE_MAX_DEFAULT = 'max_default';
    const ENABLED = 'enabled';

    const REF = 'ref';
    const UNIQUE = 'unique';
    const UNIQUE_LABEL = 'Unique';

    const POST_TITLE_SEARCH = 'title';
    const POST_CONTENT_SEARCH = 's';

    const BF_TEXT_RENDER_TYPE = 'text';
    
    const FIELD_SECTION_ID = 'section_id';
    const SUB_OPT_PARENT = 'subopt_parent';

    const IS_MENU_ITEM = 'is_menu_item';

    const NAV_MENU_TYPE = 'nav_menu_type';
    
    const CONFIG_TYPE = 'config_type';

    const API_ID = 'api_id';
    const API_CONFIG = 'api_config';

    const IMAGE_URL = 'img_url';
    const FEATURED_IMAGE = 'featured_img';

    const THUMBNAIL_IMAGE = 'thumbnail_img';

    const THUMBNAIL_IMAGE_WIDTH = 'thumb_img_width';

    const THUMBNAIL_IMAGE_HEIGHT = 'thumb_img_height';


    const LARGE_IMAGE_WIDTH = 'large_img_width';

    const LARGE_IMAGE_HEIGHT = 'large_img_height';

    const CHECKOUT_FORM_ID = 'cf_id';
    const CHECKOUT_FORM_TITLE = 'cf_title';


    const CHECKOUT_FORM_LABEL = 'cf_label';

    
    const CURRENCY_CODE = 'currency_code';

    
    const CURRENCY_POSITION = 'currency_pos';

    
    const CURRENCY_POSITION_LEFT = 'currency_pos_left';
    const CURRENCY_POSITION_RIGHT = 'currency_pos_right';
    const CURRENCY_POSITION_LEFT_SPACE = 'currency_pos_left_space';
    const CURRENCY_POSITION_RIGHT_SPACE = 'currency_pos_right_space';
    

    const DATE_LOCALE_CODE = 'date_locale_code';

    const PRIMARY_CATEGORY = 'p_cat';

    const CATEGORY_LVL1 = 'cat_lvl1';

    const CATEGORY_LVL2 = 'cat_lvl2';

    const CATEGORY_LVL3 = 'cat_lvl3';

    const CATEGORY_LVL4 = 'cat_lvl4';

    const CATEGORY_LVL5 = 'cat_lvl5';

    const CATEGORIES = 'categories';
    const TAGS = 'tags';
    const OPTIONSGROUP = 'opitonsgroup';
    const SELECT_FORM = 'select_form';

    const TAG = 'tag';
    const OPTIONGROUP = 'optgroup';
    const OPTIONGROUPS = 'optgroups';
    const OPTIONGROUP_TYPE = 'optgroup_type';

    const IMAGE_LIST = 'img_list';

    const CUSTOM_LIST = 'custom_list';

    const PRODUCT_LIST = 'product_list';

    const SELECT_BTN_LBL = 'add_to_cart';

    const HTTP_POST_URL = 'http_post_url';

    const HTTP_REDIRECT_URL = 'http_redirect_url';

    const PARAMS = 'params';
	
	const READ_MORE_URL = 'read_more_url';

    const READ_MORE = 'read_more';

    const TEXT_LINES = 'text_lines';

    const BODY_SECTION = 'body';

    const SAVE = 'save';

    const ICON = 'icon';

    const SAVE_AND_ADD_OTHER  = 'save_add_other';

    const SHIPPING_SECTION = 'shipping_section';
    
    const DESC_SECTION = 'desc_section';

    const FULL_DESC = 'full_desc';

    const PHOTO_GALLERY = 'photo_gallery';

    const GALLERY_SECTION = 'gallery_section';

    const PRODVARIANT_SECTION = 'prodvariant_section';

    const LINKEDPROD_SECTION = 'linkedprod_section';

    const SALE_START_DATE = 'sale_sdate';

    const SALE_END_DATE = 'sale_edate';

    const SALE_PERIOD = 'sale_period';

    const IMG_LIST = 'img_list';

    const MAIN_SECTION = 'main_section';

    const STEPS_STYLE = 'steps_style';
    const STYLES = 'styles';
    const GENERAL_STYLE = 'general_style';
    const ADVANCED_STYLE = 'advanced_style';

    const STEP_FORM_ENABLED = 'step_form_enabled';
    const HIDE_PREV_BTN = 'step_hide_prev_btn';
    const STEP_PREV_BTN_LBL = 'step_prev_btn_lbl';
    const STEP_NEXT_BTN_LBL = 'step_next_btn_lbl';

    const STEP_BTN_C_CLS = 'step_btn_c_cls';
    const STEP_BTN_R_CLS = 'step_btn_r_cls';
    const STEP_BTN_CLS = 'step_btn_cls';
    const STEP_PREVBTN_CLS = 'step_prevbtn_cls';
    const STEP_NEXTBTN_CLS = 'step_nextbtn_cls';
    const STEP_IND_C_CLS = 'step_ind_c_cls';
    const STEP_IND_R_CLS = 'step_ind_r_cls';
    const STEP_IND_CLS = 'step_ind_cls';
    const STEP_IND_A_CLS = 'step_ind_a_cls';

    const PASSWORD_ERROR_MSG = 'password_err_msg';

    const USERNAME = 'username';
    const USER_LOGGED_IN = 'user_logged_in';
    const USER_ROLE = 'user_role';
    const SIGN_UP = 'sign_up';
    const LOG_IN = 'log_in';
    const CHANGE_PASSWORD = 'change_password';
    const MODIFY_PROFIL = 'modify_profil';
    const RESET_PASSWORD = 'reset_password';
    const FORGOT_PASSWORD = 'forgot_password'; 
    const VERICATION_CODE = 'verification_code';
    const SIGN_UP_ADMIN_NOTIF = 'sign_up_admin_notif';
    const SIGN_UP_USER_NOTIF = 'sign_up_user_notif';
    const RESET_PASSWORD_NOTIF = 'reset_password_notif';

    const OPT_GROUP_COLOR = 'ogcolor';
    const OPT_GROUP_SIZE = 'ogsize';
    const OPT_GROUP_CUSTOM = 'ogcustom';

    const FIELD_SECTION_CONTAINER = 0;
    const FIELD_SECTION_FIELD_EDITOR = 1;
    const FIELD_SECTION_STEPPER_BUTTON = 2;
    const FIELD_SECTION_ACTION = 3;

    const FIELD_SECTION_GENERAL = 4;
    const FIELD_SECTION_SETTINGS = 5;
    const FIELD_SECTION_STYLES = 6;
    const FIELD_SECTION_CONTENT = 7;
    const FIELD_SECTION_INPUT_LAYOUT = 8;
    const FIELD_SECTION_CHOICE_LIST = 9;
    const FIELD_SECTION_LIST_SETTINGS = 10;
    const FIELD_SECTION_MULTI_STEP = 11;

    const FIELD_SECTION_OPTIONS = 12;


    const ARRAY_TYPE = '';

    /**
     * @var array
     */
    private $attrs = array();

    /**
     * Constructor
     */
    public function __construct(
        $name = "field",
        $label = 'Label',
        array $attrs = array())
    {
        parent::__construct();
        
        $this->attrs[self::NAME] = $name;
        $this->attrs[self::LABEL] = $label;
       
        $this->attrs[self::RENDER_TYPE] = self::BF_TEXT_RENDER_TYPE;
        $this->attrs[self::FIELD_SECTION_ID] = self::FIELD_SECTION_OPTIONS;
        $this->attrs[self::FIELD_TYPE] = self::OPTION_TYPE;

        $this->attrs = array_merge($this->attrs, $attrs);
    }

    public function setAttr($attrName, $attrValue) {
        $this->attrs[$attrName] = $attrValue;
    }

    /**
     * Create a new option
     * @param array $args
     */
    public static function createOption(array $args) {
        $opt = new Option();
        
        $opt->attrs = array_merge($opt->attrs, $args);

        if (isset($opt->attrs[Option::NAME]) && !isset($args[Option::LABEL])) {
            $opt->attrs[Option::LABEL] = FieldLabels::translate($opt->attrs[Option::NAME]);
        }
        
        return $opt;
    }

    public function getName() {
        return $this->attrs[self::NAME];
    }

    public function getLabel() {
        return $this->attrs[self::LABEL] ?? '';
    }

    public function getLongLabel() {
        return $this->attrs[self::LONG_LABEL] ?? '';
    }

    public function setLongLabel($value) {
        $this->attrs[self::LONG_LABEL] = $value;
    }

    public function getRenderType() {
        return $this->attrs[self::RENDER_TYPE];
    }

    public function addSubOption(BaseOption $option) {
        if (!isset($this->attrs[self::SUB_OPTIONS])) {
            $this->attrs[self::SUB_OPTIONS] = array();
        }

        $this->attrs[self::SUB_OPTIONS][$option->getName()] = $option->toArray();
        return $this;
    }

    public function addSimpleSubOption($value, $label) {
        if (!isset($this->attrs[self::SUB_OPTIONS])) {
            $this->attrs[self::SUB_OPTIONS] = array();
        }

        $this->attrs[self::SUB_OPTIONS][$value] = (new SimpleSubOption($value, $label))->toArray();
        return $this;
    }

    public function addTrueSubOption() {
        return $this->addSimpleSubOption(self::TRUE_VALUE, self::TRUE_LABEL);
    }

    public function addFalseSubOption() {
        return $this->addSimpleSubOption(self::FALSE_VALUE, self::FALSE_LABEL);
    }

    public function getSubOptions(): array {
        return $this->attrs[self::SUB_OPTIONS] ?? array();
    }

    public function setValue($value) {
        $this->attrs[self::VALUE] = $value;
    }

    public function getValue() {
        return $this->attrs[self::VALUE];
    }

    public function setInitialValue($value) {
        $this->attrs[self::DEFAULT_VALUE] = $value;
    }

    public function getInitialValue() {
        return $this->attrs[self::DEFAULT_VALUE];
    }

    public function setData(array $data) {
        $this->attrs[self::DATA] = $data;
    }

    public function toArray(): array {
        return $this->attrs;
    }
}