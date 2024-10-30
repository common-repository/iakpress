<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\ContainerField;

use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFMediaFileType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Color\ColorPaletteType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderBaseType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderFixedMinType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderStepType;

abstract class ContainerSectionBase extends AbstractFieldType
{
    public function __construct($name, $type, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, $type, $attrs);

        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);

        self::addRowLayoutProps($this);
    }

    protected static function addRowLayoutProps(AbstractFieldType &$field)
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
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        $field->addOption(
            Option::createOption([
                 Option::FIELD_TYPE => FieldRenderType::OPTION_SIMPLE_SELECT_TYPE,
                 Option::NAME => Option::HEADING_TAG,
                 Option::REQUIRED => true,
                 Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                 Option::DEFAULT_VALUE => "0",
                 Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
             ])
             ->addSimpleSubOption(0, '')
             ->addSimpleSubOption("1", "h1")
             ->addSimpleSubOption("2", "h2")
             ->addSimpleSubOption("3", "h3")
             ->addSimpleSubOption("4", "h4")
             ->addSimpleSubOption("5", "h5")
             ->addSimpleSubOption("6", "h6")
         );

         $field->addOption(
            new ColorPaletteType(
                Option::TEXT_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
                ],
                false
            )
        );


        $field->addOption(
            new ColorPaletteType(
                Option::POST_CONFIG_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
                ],
                false
            )
        );

         $field->addOption(
            new BFMediaFileType(
                Option::POST_CONFIG_BG_IMG,
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        $field->addOption(
            new SliderStepType(
                Option::POST_CONFIG_BG_OPACITY,
                [
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MAX => 1,
                    Option::VALUE => 0.7,
                    Option::RANGE_STEP => 0.1,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        
        $field->addOption(
            new SliderStepType(
                Option::POST_CONFIG_BG_MIN_HEIGHT,
                [
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MAX => 1200,
                    Option::VALUE => 700,
                    Option::RANGE_STEP => 5,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::ROW_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::PLACEHOLDER => Option::CSS_CLASS,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::LABEL_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::PLACEHOLDER => Option::CSS_CLASS,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::INPUT_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::PLACEHOLDER => Option::CSS_CLASS,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );
    }
}
