<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IALabel\LabelKey;
use App\Joosorol\IAKPress\IALabel\Labels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

/**
 * class WPFrontLabels
 */
class WPFrontLabels implements Labels
{
    private array $labels;

    public function __construct()
    {
        $this->labels = [
            LabelKey::IAKPRESS => __('IAKPress Forms', Constants::IAKPRESS),
            LabelKey::ALL  => __('All', Constants::IAKPRESS),
            LabelKey::YES  => __('Yes', Constants::IAKPRESS),
            LabelKey::NO  => __('No', Constants::IAKPRESS),
            LabelKey::OK  => __('OK', Constants::IAKPRESS),
            LabelKey::SUBMIT_SUCCESS => __('Submitted successfully.', Constants::IAKPRESS),
            LabelKey::CLOSE  => __('Close', Constants::IAKPRESS),
            LabelKey::DELETE  => __('Delete', Constants::IAKPRESS),
            LabelKey::CANCEL  => __('Cancel', Constants::IAKPRESS),
            LabelKey::NEXT  => __('Next', Constants::IAKPRESS),
            LabelKey::PREV  => __('Previous', Constants::IAKPRESS),
            LabelKey::TITLE  => __('Title', Constants::IAKPRESS),
            LabelKey::DATE  => __('Date', Constants::IAKPRESS),
            LabelKey::UPDATED_AT  => __('Last Time Modified', Constants::IAKPRESS),
            LabelKey::ACTIONS  => __('Actions', Constants::IAKPRESS),
            LabelKey::SUBMIT  => __('Save', Constants::IAKPRESS),
            LabelKey::SUBMIT_NEW  => __('Save & New', Constants::IAKPRESS),
            LabelKey::SUBMIT_CLOSE  => __('Save & Close', Constants::IAKPRESS),
            LabelKey::SAVE  => __('Save', Constants::IAKPRESS),
            LabelKey::CREATE  => __('Create', Constants::IAKPRESS),
            LabelKey::CREATE_NEW  => __('Create new', Constants::IAKPRESS),
            LabelKey::EDIT  => __('Edit', Constants::IAKPRESS),
            LabelKey::VIEW  => __('View', Constants::IAKPRESS),
            LabelKey::ADD  => __('Add', Constants::IAKPRESS),
            LabelKey::HOME  => __('Home', Constants::IAKPRESS),
            LabelKey::BACK => __('Back', Constants::IAKPRESS),
            LabelKey::SELECT => __('Select', Constants::IAKPRESS),
            LabelKey::NAME => __('Name', Constants::IAKPRESS),
            LabelKey::GROUP => __('Group', Constants::IAKPRESS),
            LabelKey::SUB_GROUP => __('Subgroup', Constants::IAKPRESS),
            LabelKey::LABEL => __('Label', Constants::IAKPRESS),
            LabelKey::STEP  => __('Step', Constants::IAKPRESS),
            LabelKey::IMPORT => __('Import', Constants::IAKPRESS),
            LabelKey::IMPORT_SUBMIT => __('I am ready. Let\'s import it to database', Constants::IAKPRESS),
            LabelKey::EXPORT => __('Export', Constants::IAKPRESS),
            LabelKey::DATA_MODELS  => __('Data Lst', Constants::IAKPRESS),
            LabelKey::NEW  => __('New', Constants::IAKPRESS),
            LabelKey::ADD_NEW  => __('Add New', Constants::IAKPRESS),
            LabelKey::PREVIEW  => __('Preview', Constants::IAKPRESS),
            LabelKey::PUBLISH  => __('Publish', Constants::IAKPRESS),
            LabelKey::UNPUBLISH  => __('Unpublish', Constants::IAKPRESS),
            LabelKey::PUBLISHED  => __('Published', Constants::IAKPRESS),
            LabelKey::UNPUBLISHED  => __('Unpublished', Constants::IAKPRESS),
            LabelKey::LIVE_VIEW  => __('Live Preview', Constants::IAKPRESS),
            LabelKey::MAINTENANCE_VIEW  => __('Maintenance Preview', Constants::IAKPRESS),
            LabelKey::DASHBOARD  => __('Dashboard', Constants::IAKPRESS),
            LabelKey::SELECT_TEMPLATE  => __('Select your template', Constants::IAKPRESS),
            LabelKey::NEW_POST  => __('New Post', Constants::IAKPRESS),
            LabelKey::NEW_MODEL  => __('New Data Set', Constants::IAKPRESS),
            LabelKey::NEW_API_KEYS  => __('New Api Keys', Constants::IAKPRESS),
            LabelKey::EDITOR  => __('Elements', Constants::IAKPRESS),
            LabelKey::POST_UNAVAILABLE  => __('Post is temporarily unavailable.', Constants::IAKPRESS),
            LabelKey::POST_UNPUBLISHED  => __('Your message is not published. Once you have finished making your changes, please publish it to allow your auditors to view this post and submit responses.', Constants::IAKPRESS),
            LabelKey::POST_TITLE  => __('Title', Constants::IAKPRESS),
            LabelKey::POST_EDIT_POST  => __('Elements', Constants::IAKPRESS),
            LabelKey::POST_DASH  => __('Dashboard', Constants::IAKPRESS),
            LabelKey::POST_EDIT_POST_SETTINGS  => __('Settings', Constants::IAKPRESS),
            LabelKey::POST_EDIT_POST_STYLE  => __('Styles', Constants::IAKPRESS),
            LabelKey::POST_EDIT_LIST_STYLE  => __('List Style', Constants::IAKPRESS),
            LabelKey::POST_EDIT_POST_MODELS  => __('Data Lists', Constants::IAKPRESS),
            LabelKey::FIELD_EDIT  => __('General', Constants::IAKPRESS),
            LabelKey::FIELD_EDITOR  => __('Form Fields', Constants::IAKPRESS),
            LabelKey::FIELD_STEPPER_BUTTON  => __('Step Buttons', Constants::IAKPRESS),
            LabelKey::FIELD_CONTAINER  => __('Form Sections', Constants::IAKPRESS),
            LabelKey::FIELD_NOTIFICATION  => __('Form Actions', Constants::IAKPRESS),
            LabelKey::FIELD_SETTINGS  => __('Field Settings', Constants::IAKPRESS),
            LabelKey::FIELD_STYLE  => __('Field Styling', Constants::IAKPRESS),
            LabelKey::FIELD_CONTENT  => __('Content', Constants::IAKPRESS),
            LabelKey::CHOICE_LIST  => __('List Settings', Constants::IAKPRESS),
            LabelKey::SINGLE_ITEM_SETTINGS  => __('Single Item Settings', Constants::IAKPRESS),
            LabelKey::BULK_ACTIONS  => __('Bulk Actions', Constants::IAKPRESS),
            LabelKey::BULK_DELETE => __('Delete', Constants::IAKPRESS),
            LabelKey::POST_EDIT_MODEL_SUBMODELS  => __('Category Groups', Constants::IAKPRESS),
            LabelKey::POST_EDIT_MENU_SETTINGS  => __('Menu', Constants::IAKPRESS),
            LabelKey::GENERAL  => __('General', Constants::IAKPRESS),
            LabelKey::CSS => __('CSS', Constants::IAKPRESS),
            LabelKey::GROUP_NAME => __('Name', Constants::IAKPRESS),
            LabelKey::PRIMARY_CATEGORY_GROUP_NAME => __('Group Name', Constants::IAKPRESS),
            LabelKey::SETTINGS  => __('Settings', Constants::IAKPRESS),
            LabelKey::FIELDS  => __('Fields', Constants::IAKPRESS),
            LabelKey::LAYOUT  => __('Layout', Constants::IAKPRESS),
            LabelKey::ENTRY_TITLE  => __('Title Field', Constants::IAKPRESS),
            LabelKey::ENTRY_CONTENT  => __('Content Field', Constants::IAKPRESS),
            LabelKey::CSS_URL  => __('CSS URL', Constants::IAKPRESS),
            LabelKey::CSS_CONTAINER  => __('CSS ContainerField', Constants::IAKPRESS),
            LabelKey::PUBLIC  => __('Public', Constants::IAKPRESS),
            LabelKey::ENTRY_CREATED_OK => __('Entry created successfully.', Constants::IAKPRESS),
            LabelKey::ENTRY_UPDATED_OK => __('Entry updated successfully.', Constants::IAKPRESS),
            LabelKey::ENTRY_DELETED_OK => __('Entry deleted successfully.', Constants::IAKPRESS),
            LabelKey::POST_SAVED_OK  => __('Form saved successfully.', Constants::IAKPRESS),
            LabelKey::POST_PUBLISHED_OK  => __('Form successfully published.', Constants::IAKPRESS),
            LabelKey::POST_UNPUBLISHED_OK  => __('Form successfully unpublished.', Constants::IAKPRESS),
            LabelKey::LICENSE_KO  => __('Your license is invalid. Some functions have been disabled!', Constants::IAKPRESS),
            LabelKey::CHECKING_LICENSE  => __('Checking License Key...', Constants::IAKPRESS),
            LabelKey::UNPUBLISH_POST_MSG  => __('Your auditors will not be able to view this post and submit any responses', Constants::IAKPRESS),
            LabelKey::DELETE_POST_MSG => __('This will permanently delete this post and all its responses. You won\ be able to recover them', Constants::IAKPRESS),
            LabelKey::SUBSCR_DETAILS_TITLE  => __('Subscription Details', Constants::IAKPRESS),
            LabelKey::SUBSCR_DETAILS_ITEM  => __('Item', Constants::IAKPRESS),
            LabelKey::SUBSCR_DETAILS_QTY  => __('No. of Units', Constants::IAKPRESS),
            LabelKey::SUBSCR_DETAILS_TOTAL  => __('Total/year', Constants::IAKPRESS),
            LabelKey::SUBSCR_LICENSE_EXP => __('Expiration Date', Constants::IAKPRESS),
            LabelKey::SUBSCR_ACTIVATION_HELP => __('Please enter your public key and private key exactly as they appear in your license email.', Constants::IAKPRESS),
            LabelKey::SUBSCR_PURCHASE_HELP => __('You can purchase a license key from our website', Constants::IAKPRESS),
            LabelKey::SUBSCR_MANAGE_TITLE  => __('Manage Subscription', Constants::IAKPRESS),
            LabelKey::SUBSCR_MANAGE_UPGRADE  => __('Upgrade', Constants::IAKPRESS),
            LabelKey::SUBSCR_MANAGE_ACTIVATE  => __('Activate License Key', Constants::IAKPRESS),
            LabelKey::SUBSCR_MANAGE_SUBMIT  => __('Activate', Constants::IAKPRESS),
            LabelKey::QUIZ_QUESTION  => __('Question', Constants::IAKPRESS),
            LabelKey::QUIZ_ANSWER  => __('Your Answer', Constants::IAKPRESS),
            LabelKey::REQUIRED_VALIDATION_MESSAGE  => __('This field is required.', Constants::IAKPRESS),
            LabelKey::MIN_VALIDATION_MESSAGE  => __(' Oops! You need to enter at least %s characters.', Constants::IAKPRESS),
            LabelKey::MAX_VALIDATION_MESSAGE  => __('Oops! You can only enter %s characters.', Constants::IAKPRESS),
            LabelKey::INVALID_VALIDATION_MESSAGE  => __('The field value is invalid.', Constants::IAKPRESS),
            LabelKey::INVALID_QUIZ_ITEM_TYPE => __('Please check API documentation. Item Type should be selected among : ', Constants::IAKPRESS),
            LabelKey::TRIAL_LICENSE => __('You are using a trial license key that will expire soon.', Constants::IAKPRESS),
            LabelKey::SUBMIT_BTN_LBLS => __('Buy Now', Constants::IAKPRESS),
            LabelKey::SELECT_BTN_LBL => __('Add to cart', Constants::IAKPRESS),
            LabelKey::YOUR_CART => __('Your Cart', Constants::IAKPRESS),
            LabelKey::DOWNLOAD_PRO_VERSION => __('Please Install IAKPress Pro To Preview', Constants::IAKPRESS),
            LabelKey::LICENSE_OK =>  __('Your license has been successfully activated.', Constants::IAKPRESS),
            LabelKey::CHOICES => __('Choices', Constants::IAKPRESS),
            LabelKey::LIST_STYLE => __('Choice Style', Constants::IAKPRESS),
            LabelKey::LIST_SETTINGS => __('List Settings', Constants::IAKPRESS),
            LabelKey::ITEMS => __('Items', Constants::IAKPRESS),
            LabelKey::IAGENERICENTRY_KEY => __('Entries', Constants::IAKPRESS),
            LabelKey::IAGENERICMODEL_KEY => __('Data Lists', Constants::IAKPRESS),
            LabelKey::IAPOSTVIEW_KEY => __('DataViews', Constants::IAKPRESS),
            LabelKey::ALL_POSTS => __('All Posts', Constants::IAKPRESS),
            LabelKey::CUSTOM_FIELDS => __('Elements', Constants::IAKPRESS),
            LabelKey::TOP_ALIGNED_LABELS    => __('Top-Aligned Labels', Constants::IAKPRESS),
            LabelKey::LEFT_ALIGNED_LABELS   => __('Left-Aligned Labels', Constants::IAKPRESS),
            LabelKey::RIGHT_ALIGNED_LABELS  => __('Right-Aligned Labels', Constants::IAKPRESS),
            LabelKey::LABELS_WITHIN_INPUTS  => __('Labels-Within Inputs', Constants::IAKPRESS),
            LabelKey::BOTTOM_ALIGNED_LABELS => __('Bottom-Aligned Labels', Constants::IAKPRESS),
            LabelKey::SUBSCR_MODULE_TILE => __('Dashboard', Constants::IAKPRESS),
            LabelKey::IAKPOST_MODULE_TITLE => __('Form', Constants::IAKPRESS),
            LabelKey::API_MODULE_TITLE => __('Add-Ons', Constants::IAKPRESS),
            LabelKey::TRIAL_LICENSE_SENT => __('Thanks. We sent you an mail with the license key to the email address you provided. Please don\'t forget to check your spam/junk/bulk mail folder, if you don\'t find the mail in your Inbox', Constants::IAKPRESS),
            LabelKey::INBOX => __('Inbox', Constants::IAKPRESS),
            LabelKey::ABOUT => __('About', Constants::IAKPRESS),
            LabelKey::HELP => __('Help', Constants::IAKPRESS),
            LabelKey::MY_ACCOUNT => __('My Account', Constants::IAKPRESS),
            LabelKey::REPORTS => __('Reports', Constants::IAKPRESS),
            LabelKey::GROUP_CHOICES => __('Data Entries', Constants::IAKPRESS),
            LabelKey::GROUP_CATEGORIES => __('Categories', Constants::IAKPRESS),
            LabelKey::GROUP_SUB_CATEGORIES => __('Sub-Groups', Constants::IAKPRESS),
            LabelKey::GROUP_FIELDS => __('Fields', Constants::IAKPRESS),
            LabelKey::DEL_CONFIRM => __('Are you sure you want to delete this record', Constants::IAKPRESS),
            LabelKey::FORMS => __('Forms', Constants::IAKPRESS),
            LabelKey::NEW_FORM => __('New Form', Constants::IAKPRESS),
            LabelKey::CHOICE_GROUPS => __('Data Lists', Constants::IAKPRESS),
            LabelKey::FORM_NAME => __('Form Name', Constants::IAKPRESS),
            LabelKey::FORM_ENTRIES => __('Data Entries', Constants::IAKPRESS),
            LabelKey::DELETE_FORM => __('Delete Form', Constants::IAKPRESS),
            LabelKey::ENTRIES => __('Entries', Constants::IAKPRESS),
            LabelKey::FIELD_SECTION => __('Edit Section', Constants::IAKPRESS),

            Constants::IA_GENERAL_STYLE_POST_TYPE => __('General Style', Constants::IAKPRESS),
            Constants::IA_STEPS_STYLE_POST_TYPE => __('Steps Style', Constants::IAKPRESS),
            Constants::IA_ADVANCED_STYLE_POST_TYPE => __('Advanced Style', Constants::IAKPRESS),

            LabelKey::DRAG_AND_DROP => __('Drag and Drop', Constants::IAKPRESS),
            LabelKey::FIELD_TYPE => __('Field Type', Constants::IAKPRESS),
            LabelKey::FIELD_NAME => __('Field Name', Constants::IAKPRESS),

            LabelKey::UNABLE_TO_RENDER_POST => __('Unable to render the form.', Constants::IAKPRESS),

            LabelKey::CPT_CUSTOM_FIELDS => __('Elements', Constants::IAKPRESS),
            Constants::IA_CPT_LABELS => __('Labels', Constants::IAKPRESS),
            LabelKey::STYLES_TYPE => __('Styles', Constants::IAKPRESS),
            LabelKey::CPT_BASIC_SETTINGS => __('Settings', Constants::IAKPRESS),
            Constants::IA_CPT_ADAVANCED_SETTINGS => __('Advanced Settings', Constants::IAKPRESS),

            Constants::IA_TAXO_LABELS => __('Labels', Constants::IAKPRESS),
            Constants::IA_TAXO_ADAVANCED_SETTINGS => __('Advanced Settings', Constants::IAKPRESS),

            LabelKey::SUBMIT_DISABLED => __('Unable to submit form. Please make sure your form is published.', Constants::IAKPRESS),

            LabelKey::MULTI_STEP => __('Multi Step', Constants::IAKPRESS),
            LabelKey::FORM_SECTION => __('Section', Constants::IAKPRESS),

            LabelKey::BUILD => __('Build', Constants::IAKPRESS),
            LabelKey::ELEMENTS => __('Elements', Constants::IAKPRESS),
            LabelKey::CUSTOMIZE => __('Customize', Constants::IAKPRESS),
            LabelKey::NEW_SUB_GROUP => __('New Sub-Group', Constants::IAKPRESS),
            LabelKey::SELECT_FILE => __('Select File', Constants::IAKPRESS),
            LabelKey::APPLY => __('Apply', Constants::IAKPRESS),
            LabelKey::CLOSE => __('close', Constants::IAKPRESS),

            LabelKey::INTEGRATIONS => __('Integrations', Constants::IAKPRESS),

            LabelKey::LENGTH => __('Length', Constants::IAKPRESS),
            LabelKey::WIDTH => __('Width', Constants::IAKPRESS),
            LabelKey::HEIGHT => __('Height', Constants::IAKPRESS),

            LabelKey::VISUAL => __('Visual', Constants::IAKPRESS),
            LabelKey::TEXT => __('Text', Constants::IAKPRESS),

            LabelKey::UP_SELLS => __('Up-sells', Constants::IAKPRESS),
            LabelKey::CROSS_SELLS => __('Cross-sells', Constants::IAKPRESS),

            LabelKey::FORM => __('Form', Constants::IAKPRESS),
            LabelKey::PRICE => __('Price', Constants::IAKPRESS),
            LabelKey::SALE_START_DATE => __('From', Constants::IAKPRESS),
            LabelKey::SALE_END_DATE => __('To', Constants::IAKPRESS),

            LabelKey::CATEGORIES => __('Categories', Constants::IAKPRESS),
            LabelKey::TAG => __('Tag', Constants::IAKPRESS),
            LabelKey::OPTIONSGROUP => __('Options Group', Constants::IAKPRESS),
            LabelKey::SELECT_FORM => __('Select Form', Constants::IAKPRESS),

            LabelKey::OR => __('OR', Constants::IAKPRESS),
            LabelKey::FORGOT_PASSWORD => __('Forgot your password ?', Constants::IAKPRESS),
            LabelKey::CANT_LOG_IN => __("Can't Log In?", Constants::IAKPRESS),
            LabelKey::NOT_HAVE_ACCOUNT => __("Don't have an account ?", Constants::IAKPRESS),
            LabelKey::SIGN_UP => __("Sign Up", Constants::IAKPRESS),
            LabelKey::LOG_IN => __("Log In", Constants::IAKPRESS),
            LabelKey::HAVE_ACCOUNT => __("Already have an account ?", Constants::IAKPRESS),
            LabelKey::ACTIVATE_ACCOUNT => __("Activate account", Constants::IAKPRESS),

            Option::GROUP_ID => __('Group name', Constants::IAKPRESS),
            Option::OPTION_ID => __('Option name', Constants::IAKPRESS),
            Option::REGULAR_PRODUCT_PRICE => __('Regular price', Constants::IAKPRESS),

            Option::PLEASE_WAIT => __('Please wait...', Constants::IAKPRESS),
        ];
    }


    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getLabelByKey(string $key, string $defaultValue = null) : string {
        if (isset($this->labels[$key])) {
            return $this->labels[$key];
        }

        return !empty($defaultValue) ? $defaultValue : $key;
    }
}
