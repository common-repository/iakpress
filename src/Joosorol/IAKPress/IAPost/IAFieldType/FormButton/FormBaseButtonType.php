<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\FormButton;

use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderFixedMinType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderBaseType;

abstract class FormBaseButtonType extends AbstractFieldType
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
                
        $this->addWidthOption();

        $this->addOption(
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

        $this->addOption(
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

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::ROW_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );


        $this->addOption(
            Option::createOption([
                Option::NAME => Option::INPUT_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::LABEL_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $this->addOption(
            new BFTextType(
                Option::HTTP_POST_URL,
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        $this->addOption(
            new BFTextType(
                Option::HTTP_REDIRECT_URL,
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );


        $this->addOption(
            Option::createOption([
                Option::NAME => Option::HELP,
                Option::RENDER_TYPE => AbstractFieldType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );


        $this->addOption(
            Option::createOption([
                Option::NAME => Option::SUCCESS_MSG,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::ERROR_MSG,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::CONTENT,
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::CONTENT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );
    }

    protected function addWidthOption() {
        $this->addOption(
            new SliderFixedMinType(
            Option::ROW_WIDTH,
            [
                Option::RANGE => Option::RANGE_MIN,
                Option::RANGE_MIN => 1,
                Option::RANGE_MIN_DEFAULT => 1,
                Option::RANGE_MAX => 12,
                Option::RANGE_MAX_DEFAULT => 12,
                Option::VALUE => 12,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ],
            false
        ));

        $this->addOption(
            new SliderFixedMinType(
                Option::LABEL_WIDTH,
                [
                    Option::RANGE => SliderBaseType::RANGE_MIN,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MIN_DEFAULT => 0,
                    Option::RANGE_MAX => 12,
                    Option::RANGE_MAX_DEFAULT => 12,
                    Option::VALUE => 3,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            ));
    }
}
