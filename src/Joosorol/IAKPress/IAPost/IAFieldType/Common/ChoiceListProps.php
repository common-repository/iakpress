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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Color\ColorPaletteType;

class ChoiceListProps
{
    const CSS_CLASS = "CSS class(es)";

    private function __construct()
    {
    }

    public static function add(AbstractFieldType &$field)
    {

        // add model_id
        $field->addOption(Option::createOption([
            Option::NAME => Option::MODEL_ID,
            Option::LABEL =>   FieldLabels::translate(Option::MODEL_ID),
            Option::REQUIRED => true,
            Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
            Option::FIELD_TYPE =>  FieldRenderType::OPTION_GENERIC_MODEL_TYPE
        ]));

         
         // add parent_field
         $field->addOption(Option::createOption([
            Option::NAME => Option::PARENT_FIELD,
            Option::LABEL =>  FieldLabels::translate(Option::PARENT_FIELD),
            Option::REQUIRED => false,
            Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
            Option::FIELD_TYPE => FieldRenderType::OPTION_PARENT_FIELD_TYPE,
        ]));


        $field->addOption(
            Option::createOption([
                Option::NAME => Option::ITEMS_ORDER_BY,
                Option::LABEL =>  FieldLabels::translate(Option::ITEMS_ORDER_BY),
                Option::REQUIRED => false,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::FIELD_TYPE => FieldRenderType::OPTION_ORDER_BY_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::ITEMS_ORDER_DIRECTION,
                Option::LABEL =>  FieldLabels::translate(Option::ITEMS_ORDER_DIRECTION),
                Option::REQUIRED => false,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::FIELD_TYPE => FieldRenderType::OPTION_ORDER_DIRECTION_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
            ])
        );

        $field->addOption(
            new SliderStepType(
                Option::ITEMS_PER_ROW,
                [
                    Option::LABEL =>   FieldLabels::translate(Option::ITEMS_PER_ROW),
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 1,
                    Option::RANGE_MAX => 6,
                    Option::VALUE => 4,
                    Option::RANGE_STEP => 1,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS,
                ],
                false
            )
        );

        $field->addOption(
            new SliderStepType(
                Option::ITEMS_PER_PAGE,
                [
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 1,
                    Option::RANGE_MAX => 60,
                    Option::VALUE => 10,
                    Option::RANGE_STEP => 1,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS,
                ],
                false
            )
        );


        $field->addOption(
            new ColorPaletteType(
                Option::ITEMS_TEXT_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::TEXT_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );


        $field->addOption(
            new ColorPaletteType(
                Option::ITEMS_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::ITEMS_BG_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );

        $field->addOption(
            new ColorPaletteType(
                Option::ITEMS_HOVER_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::ITEMS_HOVER_BG_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );

        $field->addOption(
            new ColorPaletteType(
                Option::ITEMS_HOVER_TEXT_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::ITEMS_HOVER_TEXT_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );

        $field->addOption(
            new ColorPaletteType(
                Option::SELECTED_ITEM_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::SELECTED_ITEM_BG_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );

        $field->addOption(
            new ColorPaletteType(
                Option::SELECTED_ITEM_TEXT_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::SELECTED_ITEM_TEXT_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );

        $field->addOption(
            new ColorPaletteType(
                Option::CHECKMARK_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::LABEL => FieldLabels::translate(Option::CHECKMARK_BG_COLOR),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS
                ],
                false
            )
        );
        
        $field->addOption(
            Option::createOption([
                Option::NAME => Option::ITEMS_HIDE_CHECKMARK,
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_LIST_SETTINGS,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::REQUIRED,
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );


        // settings
        $field->addOption(
            Option::createOption([
                Option::NAME => Option::PLACEHOLDER,
                Option::RENDER_TYPE => AbstractFieldType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );


        $field->addOption(
            Option::createOption([
                Option::NAME => Option::HELP,
                Option::RENDER_TYPE => AbstractFieldType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::ERROR_MSG,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::CONTENT,
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::CONTENT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );
    }
}
