<?php

/*
 * This file is part of iakboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IATemplate\PostTypeUtils;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFSlugType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Checkbox\BasicCheckboxType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderBaseType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderStepType;

class PostConfig extends AbstractPostType {
    const POST_TYPE = Constants::IA_POST_CONFIG_POST_TYPE;
    const POST_SETTINGS = 'settings';
    CONST NAME = Constants::IA_POST_CONFIG_POST_TYPE;
    const LABEL = 'General Settings';
    const POST_CONFIG_ID = 'id';
    const POST_CONFIG_TITLE = Option::POST_CONFIG_TITLE;
    const POST_CONFIG_TITLE_LABEL = 'Name';
    const POST_CONFIG_DESC = 'desc';
    const POST_CONFIG_NAME = 'name';
    const CREATED_AT = 'created_at';
    const CREATED_AT_GMT = 'created_at_gmt';
    const UPDATED_AT = 'updated_at';
    const UPDATED_AT_GMT = 'updated_at_gmt';
    const COUNT_ENTRIES = 'count_entries';
    const USER_ID = 'user_id';
    const POST_CONFIG_PARENT_ID = 'parent_id';
    const POST_CONFIG_META_DESC = 'meta_desc';
    const POST_CONFIG_META_KEYWORDS = 'meta_keys';
    const MENU_ORDER = 'menu_order';
    const FIELDS = 'fields';
    const MODELS = 'models';
    const CONTAINERS = 'containers';
    const NB_CONTAINERS = 'nb_containers';
    const SUBMIT_COUNT = 'submit_count';
    const NEW_ENTRIES_COUNT = 'new_entries_count';
    const SIGNUP_SECTION = 'signup_section';


    const ACTIONS = 'actions';
    const NB_ACTIONS = 'nb_actions';


    const NB_FORM_FIELDS = 'nb_form_fields';

    const CHOICE_LIST = 'choice_list';
    const POST_CONFIG_ATTRS = Option::ATTRS;
    const POST_CONFIG_TYPE = 'type';
    const POST_CONFIG_PUBLISHED = 'published';

    const SUBMIT_NAME = 'submit_name';
    const ENTRY_TITLE = Option::ENTRY_TITLE;
    const ENTRY_CONTENT = Option::ENTRY_CONTENT;

    const POST_CONFIG_LAYOUT = Option::POST_CONFIG_LAYOUT;


    const DEFAULT_MENU = 'default_menu';

    const ALLOW_ADD_FIELDS = Option::ALLOW_ADD_FIELDS;

    const POST_CONFIG_CONFIG_KEY = 'formConfig';
    const CLIENT_CONFIG_KEY = 'clientConfig';
    const INBOX_DATA_KEY = 'inboxData';
    const ADDONS_DATA_KEY = 'addonsData';

    const POST_CONFIG_DATA_KEY = 'formData';
    const POST_CONFIG_ELEMENT_ID = 'postElementId';
    const POST_CONFIG_PREVIEW_URL = 'postPreviewUrl';
    const POST_CONFIG_VALUES_ELEMENT_ID = 'postValuesElementId';
    const POST_CONFIG_ERRORS_ELEMENT_ID = 'postErrorsElementId';
    const PARENT_NODE = Constants::PARENT_NODE;
    const FIELDS_KEY = 'fields';

    const POST_CONFIG_INLINE_CSS = 'i_css';
    const POST_CONFIG_INLINE_CSS_LABEL = 'Inline CSS';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::NAME); 

        $this->addField(
            new BFTextType(
                self::POST_CONFIG_TITLE,
                [
                    Option::LABEL => FieldLabels::translate(Option::NAME),
                    Option::REQUIRED => true,
                    Option::MIN_LENGTH => 2,
                    Option::PLACEHOLDER => 'Form Name'
                ],
                false
            )
        );

        $this->addField(
            new BFSlugType(
                Option::CPT_NAME,
                [
                    Option::REQUIRED => true,
                    Option::MIN_LENGTH => 2,
                    Option::PLACEHOLDER => 'CPT Slug'
                ],
                false
            )
        );

        
        $this->addField(
            Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_DATE_LOCALE_CODE_TYPE,
                Option::NAME => Option::DATE_LOCALE_CODE,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE
            ])
        );

        $this->addField(
            Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_CURRENCY_TYPE,
                Option::NAME => Option::CURRENCY_CODE,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE
            ])
        );

        $this->addField(
            Option::createOption([
                 Option::FIELD_TYPE => FieldRenderType::OPTION_SIMPLE_SELECT_TYPE,
                 Option::NAME => Option::CURRENCY_POSITION,
                 Option::REQUIRED => false,
                 Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                 Option::DEFAULT_VALUE => 1,
             ])
             ->addSimpleSubOption("1", FieldLabels::translate(Option::CURRENCY_POSITION_LEFT))
             ->addSimpleSubOption("2", FieldLabels::translate(Option::CURRENCY_POSITION_RIGHT))
             ->addSimpleSubOption("3", FieldLabels::translate(Option::CURRENCY_POSITION_LEFT_SPACE))
             ->addSimpleSubOption("4", FieldLabels::translate(Option::CURRENCY_POSITION_RIGHT_SPACE)));


        $this->addField(
            new SliderStepType(
                Option::THUMBNAIL_IMAGE_WIDTH,
                [
                    Option::UNIT => "px",
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 40,
                    Option::RANGE_MAX => 600,
                    Option::VALUE => 150,
                    Option::RANGE_STEP => 1
                ],
                false
            )
        );


        $this->addField(
            new SliderStepType(
                Option::THUMBNAIL_IMAGE_HEIGHT,
                [
                    Option::UNIT => "px",
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 40,
                    Option::RANGE_MAX => 600,
                    Option::VALUE => 150,
                    Option::RANGE_STEP => 1
                ],
                false
            )
        );

        $this->addField(
            new SliderStepType(
                Option::LARGE_IMAGE_WIDTH,
                [
                    Option::UNIT => "px",
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 150,
                    Option::RANGE_MAX => 800,
                    Option::VALUE => 390,
                    Option::RANGE_STEP => 1
                ],
                false
            )
        );


        $this->addField(
            new SliderStepType(
                Option::LARGE_IMAGE_HEIGHT,
                [
                    Option::UNIT => "px",
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 150,
                    Option::RANGE_MAX => 800,
                    Option::VALUE => 490,
                    Option::RANGE_STEP => 1
                ],
                false
            )
        );

        $this->addField(
            new BasicCheckboxType(
                Option::LOGIN_REQUIRED,
                [
                    Option::LABEL => FieldLabels::translate(Option::LOGIN_REQUIRED)
                ],
                false
            )
        );

        $this->addField(
            new BasicCheckboxType(
                Option::ENABLE_SHOPPING_CART,
                [
                    Option::LABEL => FieldLabels::translate(Option::ENABLE_SHOPPING_CART)
                ],
                false
            )
        );
    }

    public static function getSupports($formConfig) {
        $tplType = $formConfig[PostConfig::POST_CONFIG_TYPE] ?? '';

        $parentTplId = TemplateTypes::getParentTypeId($tplType);

        if ($parentTplId == TemplateTypes::FT_MODEL_GROUP) {
            return PostTypeUtils::getSupports($tplType);
        } else {
            return array('title', 'editor');
        }
    }
}
