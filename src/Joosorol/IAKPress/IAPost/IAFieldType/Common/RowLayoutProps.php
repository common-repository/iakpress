<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;

class RowLayoutProps
{
    private function __construct()
    { }

    public static function add(AbstractFieldType &$field)
    {

        $field->addOption(
            new SliderFixedMinType(
                Option::ROW_WIDTH,
                [
                    Option::RANGE => SliderBaseType::RANGE_MIN,
                    Option::RANGE_MIN => 1,
                    Option::RANGE_MIN_DEFAULT => 1,
                    Option::RANGE_MAX => 12,
                    Option::RANGE_MAX_DEFAULT => 12,
                    Option::VALUE => 12,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
                ],
                false
            )
        );

        $field->addOption(
            new SliderFixedMinType(
                Option::LABEL_WIDTH,
                [
                    Option::RANGE => SliderBaseType::RANGE_MIN,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MIN_DEFAULT => 0,
                    Option::RANGE_MAX => 12,
                    Option::RANGE_MAX_DEFAULT => 12,
                    Option::VALUE => 3,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
                ],
                false
            ));

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::ROW_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::INPUTGROUP_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );


        $field->addOption(
            Option::createOption([
                Option::NAME => Option::INPUT_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::LABELGROUP_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::LABEL_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::HIDE_LABEL,
                Option::FIELD_TYPE => FieldRenderType::BF_CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::REVERSE,
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );
    }
}
