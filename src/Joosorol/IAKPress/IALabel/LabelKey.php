<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IALabel;

/**
 * class LabelKey
 */
class LabelKey
{
    const IAKPRESS = 'iakpress';
    const ALL = 'all';
    const BG_COLOR = 'bg_color';
    const FILE_PATH = 'file_path';
    const IMAGE_THUMBNAIL_PATH = 'thumbnail_path';
    const BG_IMG = 'bg_img';
    const FIELD_TYPE = 'field_type';
    const MODEL_TYPE = 'field_sub_type';
    const TRIGGER_TYPE = 'trigger_type';
    const MODEL_ID = 'model_id';
    const NAV_MENU_ID = 'nav_menu_id';
    const CHOICE_TYPE = 'choice_type';
    const CHOICE_SUB_POST_CONFIG = 'choice_sub_post_config';
    const CONTENT_TYPE = 'content_type';
    const CONTENT_TITLE = 'content_title';
    const MIN_LENGTH = 'min_length';
    const VALUE = 'value';
    const DEFAULT_VALUE = 'default_value';
    const DEFAULT = 'default';
    const HELP_CLASS = 'help_class';
    const SUCCESS_MSG = 'success_msg';
    const ERROR_MSG = 'error_msg';
    const CHAR_COUNT = 'char_count';
    const DISABLED = 'c_disabled';
    const IAK_SCORE = 'iak_score';
    const IS_VALID = 'c_valid';
    const HIDE = 'hide';
    const POST_CONFIG_BG_COLOR = 'post_config_bg_color';
    const POST_CONFIG_BG_IMG = 'post_config_bg_img';
    const POST_CONFIG_BG_OPACITY = 'post_config_bg_opacity';
    const POST_CONFIG_BG_MIN_HEIGHT = 'post_config_bg_min_height';
    const POST_CONFIG_BODY_CLASS = 'post_config_body_class';
    const COLUMN_WIDTH = 'column_width';
    const COLUMN_HEIGHT = 'column_height';
    const ITEMS_MAIN_COLUMN = 'items_main_column';
    const ITEMS_HEADER_COLUMN = 'items_header_column';
    const ITEMS_FOOTER_COLUMN = 'items_footer_column';
    const REF_TYPE = 'ref_type';
    const REF_ARCHIVE_VIEW_ID = 'ref_a_view_id';
    const REF_SINGLE_VIEW_ID = 'ref_single_view_id';
    const IAK_FIELD = 'iak_field';
    const IAK_POST = 'iak_post';
    const ITEMS_CONTAINER_WIDTH = 'items_layout_field_width';
    const ITEMS_PER_ROW = 'items_per_row';
    const ITEMS_PER_PAGE = 'items_per_page';
    const ITEMS_BG_IMG = 'items_bg_img';
    const ITEMS_IMG_OPACITY = 'items_bg_opacity';
    const ITEMS_IMG_HEIGHT = 'items_bg_min_height';
    const ITEMS_BG_COLOR = 'items_bg_color';
    const ITEMS_CLASS = 'items_class';
    const ITEMS_STYLE = 'items_style';
    const ITEMS_LINK_CLASS = 'items_link_class';
    const REVERSE = 'reverse';
    const POST_TYPE = 'post_type';
    const LIST_ITEMS_PER_ROW = 'list_items_per_row';
    const CONTAINER_ID = 'container_id';
    const PAGE_NAME = 'page_name';
    const SECTION_NAME = 'section_name';
    const CHECK_GROUP_1 = 'check_group_1';
    const C_DISABLED = 'c_disabled';
    const HELP = 'help';
    const LABEL = 'label';
    const NAME = 'name';
    const SHORT_NAME = 'short_name';
    const LONG_LABEL = 'long_label';
    const REQUIRED = 'required';
    const UNIQUE = 'unique';
    const READONLY = 'readonly';
    const FIELD_WIDTH = 'field_width';
    const LABEL_WIDTH = 'label_width';
    const ROW_WIDTH = 'row_width';
    const TRIM = 'trim';
    const PLACEHOLDER = 'placeholder';
    const MAX_LENGTH = 'max_length';
    const ROW_CLASS = 'row_class';
    const ROW_STYLE = 'row_style';
    const LABEL_CLASS = 'label_class';
    const LABEL_STYLE = 'label_style';
    const INPUTGROUP_CLASS = 'inputgroup_class';
    const INPUTGROUP_STYLE = 'inputgroup_style';
    const INPUT_CLASS = 'input_class';
    const INPUT_STYLE = 'input_style';
    const DELETE = 'delete';
    const DATA = 'data';
    const IS_MENU_ITEM = 'is_menu_item';
    const NAV_MENU_TYPE = 'nav_menu_type';
    const CONFIG_TYPE = 'config_type';
    const GROUP_NAME = 'group_name';
    const PRIMARY_CATEGORY_GROUP_NAME = 'cat_group_name';
    const GROUP_CATEGORIES = 'group_categories';
    const GROUP_SUB_CATEGORIES = 'group_sub_categories';
    const FORM_SECTION = 'form_section';

    const OK = 'ok';
    const CLOSE = 'close';
    const YES = 'yes';
    const NO = 'no';
    const CANCEL = 'cancel';
    const NEXT = 'next';
    const PREV = 'prev';
    const TITLE = 'title';
    const DATE = 'date';
    const UPDATED_AT = 'updated_at';
    const ACTIONS = 'actions';
    const SUBMIT = 'submit';
    const SUBMIT_NEW = 'submit_new';
    const SUBMIT_CLOSE = 'submit_close';
    const SAVE = 'save';
    const CREATE = 'create';
    const CREATE_NEW = 'create_new';
    const EDIT = 'edit';
    const VIEW = 'view';
    const ADD = 'add';
    const HOME = 'home';
    const BACK = 'back';
    const SELECT = 'select';
    const STEP = 'step';
    const DATA_MODELS = 'data_models';
    const NEW = 'new';
    const GROUP = 'group';
    const SUB_GROUP = 'subgroup';
    const IMPORT = 'import';
    const EXPORT = 'export';
    const ADD_NEW = 'add_new';
    const PREVIEW = 'preview';
    const PUBLISH = 'publish';
    const UNPUBLISH = 'unpublish';
    const PUBLISHED = 'published';
    const UNPUBLISHED = 'unpublished';
	const LIVE_VIEW = 'live_view';
	const MAINTENANCE_VIEW = 'maintenance_view';
	const DASHBOARD = 'dashboard';
    const SELECT_TEMPLATE = 'select_template';
    const NEW_POST = 'new_post';
    const NEW_MODEL = 'new_model';
    const NEW_API_KEYS = 'new_api_keys';
    const EDITOR = 'editor';
    const POST_UNAVAILABLE = 'post_unavailable';
    const POST_UNPUBLISHED = 'post_unpublished';
    const POST_TITLE = 'post_title';
    const POST_DASH = 'post_dash';
    const POST_EDIT_POST = 'post_edit_post';
    const POST_EDIT_POST_SETTINGS = 'post_edit_post_settings';
    const POST_EDIT_POST_STYLE = 'post_edit_post_style';
    const POST_EDIT_LIST_STYLE = 'post_edit_list_style';
    const POST_EDIT_POST_MODELS = 'post_edit_post_models';
    const FIELD_EDIT = 'field_edit';
    const FIELD_EDITOR = 'field_editor';
    const FIELD_STEPPER_BUTTON = 'field_stepper_button';
    const FIELD_CONTAINER = 'field_container';
    const FIELD_NOTIFICATION = 'field_notification';
    const FIELD_SETTINGS = 'field_settings';
    const FIELD_STYLE = 'field_style';
    const FIELD_CONTENT = 'field_content';
    const CHOICE_LIST = 'choice_list';
    const CHOICES = 'choices';
    const LIST_STYLE = 'list_style';
    const LIST_SETTINGS = 'list_settings';
    const BULK_ACTIONS = 'bulk_actions';
    const POST_EDIT_MODEL_SUBMODELS = 'post_edit_model_submodels';
    const POST_EDIT_MENU_SETTINGS = 'post_edit_menu_settings';
    const GENERAL = 'general';
    const SETTINGS = 'settings';
    const FIELDS = 'fields';
    const LAYOUT = 'layout';
    const ENTRY_TITLE = 'entry_title';
    const ENTRY_CONTENT = 'entry_content';
    const CSS_URL = 'css_url';
    const CSS_CONTAINER = 'css_container';
    const CSS = 'css';
    const PUBLIC = 'public';
    const ENTRY_CREATED_OK = 'entry_created_ok';
    const ENTRY_UPDATED_OK = 'entry_updated_ok';
    const ENTRY_DELETED_OK = 'entry_deleted_ok';
    const POST_SAVED_OK = 'post_saved_ok';
    const POST_PUBLISHED_OK = 'post_published_ok';
    const POST_UNPUBLISHED_OK = 'post_unpublished_ok';
    const LICENSE_KO = 'license_ko';
    const CHECKING_LICENSE = 'checking_license';
    const UNPUBLISH_POST_MSG = 'unpublish_post_msg';
    const DELETE_POST_MSG = 'delete_post_msg';
    const SUBSCR_DETAILS_TITLE = 'subscr_details_title';
    const SUBSCR_DETAILS_ITEM = 'subscr_details_item';
    const SUBSCR_DETAILS_QTY = 'subscr_details_qty';
    const SUBSCR_DETAILS_TOTAL = 'subscr_details_total';
    const SUBSCR_LICENSE_EXP = 'subscr_license_exp';
    const SUBSCR_ACTIVATION_HELP = 'subscr_activation_help';
    const SUBSCR_PURCHASE_HELP = 'subscr_purchase_help';
    const SUBSCR_MANAGE_TITLE = 'subscr_manage_title';
    const SUBSCR_MANAGE_UPGRADE = 'subscr_manage_upgrade';
    const SUBSCR_MANAGE_ACTIVATE = 'subscr_manage_activate';
    const SUBSCR_MANAGE_SUBMIT = 'subscr_manage_submit';
    const QUIZ_QUESTION = 'quiz_question';
    const QUIZ_ANSWER = 'quiz_answer';
    const REQUIRED_VALIDATION_MESSAGE = 'required_validation_message';
    const MIN_VALIDATION_MESSAGE = 'min_validation_message';
    const MAX_VALIDATION_MESSAGE = 'max_validation_message';
    const INVALID_VALIDATION_MESSAGE = 'invalid_validation_message';
    const INVALID_QUIZ_ITEM_TYPE = 'invalid_quiz_item_type';

    const SUBMIT_SUCCESS = 'submit_success';
    const TRIAL_LICENSE = 'trial_license';
    const SUBMIT_BTN_LBLS = 'buy_now';
    const SELECT_BTN_LBL = 'add_to_cart';
    const YOUR_CART = 'your_cart';

    const UNABLE_TO_RENDER_POST = 'unable_to_render_post';
    const DOWNLOAD_PRO_VERSION = 'download_pro_version';
    const LICENSE_OK = 'license_ok';
    const ITEMS = 'items';

    const IAGENERICENTRY_KEY = 'iagenericentry';
    const IAGENERICMODEL_KEY = 'iagenericmodel';
    const IAPOSTVIEW_KEY = 'iapostview';
    const ALL_POSTS = 'all_posts';
    const CUSTOM_FIELDS = 'custom_fields';

    const TOP_ALIGNED_LABELS = 'top_aligned_labels';
    const LEFT_ALIGNED_LABELS = 'left_aligned_labels';
    const RIGHT_ALIGNED_LABELS = 'right_aligned_labels';
    const LABELS_WITHIN_INPUTS = 'labels_within_inputs';
    const BOTTOM_ALIGNED_LABELS = 'bottom_aligned_labels';

    const TRIAL_LICENSE_SENT = 'trial_license_sent';


    const SUBSCR_MODULE_TILE = 'subscr_module_title';
    const IAKPOST_MODULE_TITLE = 'iakpost_module_title';
    const API_MODULE_TITLE = 'api_module_title';

    const IMPORT_SUBMIT = 'import_submit';

    const INBOX = 'inbox';
    const ABOUT = 'about';
    const MY_ACCOUNT = 'my_account';
    const REPORTS = 'reports';

    const SUBJECT = 'subject';
    const MESSAGE = 'message';
    const EMAIL = 'email';

    const GROUP_CHOICES = 'group_choices';
    const GROUP_SUBGROUPS = 'group_subgroups';
    const GROUP_FIELDS = 'group_fields';

    const DEL_CONFIRM = 'del_confirm';
    const FORMS = 'forms';
    const NEW_FORM = 'new_form';

    const CHOICE_GROUPS = 'choicegroups';
    const FORM_NAME = 'form_name';
    const FORM_ENTRIES = 'form_entries';
    const DELETE_FORM = 'del_form';
    const ENTRIES = 'entries';
    const FIELD_SECTION = 'field_section';

    const DRAG_AND_DROP = 'drag_and_drop';

    const FIELD_NAME = 'field_name';

    const CPT_CUSTOM_FIELDS = 'iacptcf';
    const STYLES_TYPE = 'iastyles';
    const CPT_BASIC_SETTINGS = 'iacptbasic';
    const POST_CSS_TYPE = 'iapostcss';
    const CPT_CHOICE_GROUPS = 'iacptchoicegroups';

    const SUBMIT_DISABLED = 'submit_disabled';
    const MULTI_STEP = 'multi_step';
    const BUILD = 'build';
    const ELEMENTS = 'elements';
    const CUSTOMIZE = 'customize';

    const NEW_SUB_GROUP = 'new_sub_group';
    const SELECT_FILE = "select_file";

    const APPLY = 'apply';

    const INTEGRATIONS = 'integrations';

    const BULK_DELETE = 'bulk_delete';

    const LENGTH = 'length';
    const WIDTH = 'width';
    const HEIGHT = 'height';

    const VISUAL = 'visual';
    const TEXT = 'text';

    const UP_SELLS = 'up_sells';
    const CROSS_SELLS = 'cross_sells';

    const FORM = 'form';
    const PRICE= 'price';
    const SALE_START_DATE = 'sale_sdate';
    const SALE_END_DATE = 'sale_edate';

    const SINGLE_ITEM_SETTINGS = 'single_item_settings';

    const CATEGORIES = 'categories';
    const TAG = 'tag';
    const TAGS = 'tags';
    const OPTIONSGROUP = 'opitonsgroup';
    const SELECT_FORM = 'select_form';

    const OR = 'or';
    const FORGOT_PASSWORD = 'forgot_password';
    const CANT_LOG_IN = 'cant_log_in';
    const NOT_HAVE_ACCOUNT = 'not_have_account';
    const SIGN_UP = 'sign_up';
    const LOG_IN = 'log_in';
    const HAVE_ACCOUNT = 'have_account';
    const ACTIVATE_ACCOUNT = 'activate_account';
}
