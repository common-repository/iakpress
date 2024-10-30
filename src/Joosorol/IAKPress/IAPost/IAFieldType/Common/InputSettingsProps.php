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
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFIntegerType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;

class InputSettingsProps
{
    private function __construct()
    {
    }

    public static function add(AbstractFieldType &$field)
    {
        $parentType = FieldRenderType::getParentTypeId($field->getType());

        if ($parentType == FieldRenderType::SELECT_BF_TYPE 
            || $parentType == FieldRenderType::SELECT_CHECKBOX_TYPE
            || $parentType == FieldRenderType::SELECT_OPTION_TYPE
            || $parentType == FieldRenderType::SELECT_MEDIA_TYPE) {
            $field->addOption(
                Option::createOption([
                    Option::NAME => Option::REQUIRED,
                    Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                    Option::VALUE => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ])
            );
        }

        if ($parentType == FieldRenderType::SELECT_BF_TYPE) {
            $field->addOption(
                Option::createOption([
                    Option::NAME => Option::UNIQUE,
                    Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                    Option::VALUE => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ])
            );
        }


        if ($parentType == FieldRenderType::SELECT_BF_TYPE) {
            $field->addOption(
                new BFTextType(
                    Option::PATTERN,
                    [
                        Option::LABEL => FieldLabels::translate(Option::PATTERN),
                        Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                    ],
                    false
                )
            );
    

            $field->addOption(
                new BFIntegerType(
                    Option::MIN_LENGTH,
                    [
                        Option::VALUE => 0,
                        Option::LABEL => FieldLabels::translate(Option::MIN_LENGTH),
                        Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                    ],
                    false
                )
            );
    
            $field->addOption(
                new BFIntegerType(
                    Option::MAX_LENGTH,
                    [
                        Option::VALUE => 0,
                        Option::LABEL => FieldLabels::translate(Option::MAX_LENGTH),
                        Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                    ],
                    false
                )
            );
        }

        if (
            $parentType == FieldRenderType::SELECT_BF_TYPE) {
            $field->addOption(
                Option::createOption([
                    Option::NAME => Option::PLACEHOLDER,
                    Option::RENDER_TYPE => AbstractFieldType::BF_TEXT_RENDER_TYPE,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ])
            );
        }

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
                Option::NAME => Option::FORMAT_MSG,
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
