<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;


class SliderRangeType extends SliderBaseType {
    const TYPE = AbstractFieldType::SLIDER_RANGE_TYPE;
    const RENDER_TYPE = AbstractFieldType::SLIDER_RENDER_TYPE;

    const RANGE_POST_CONFIG_TITLE = 'Range';

    const MIN_VALUE_LABEL = 'Min Value';
    const MAX_VALUE_LABEL = 'Max Value';
    const BLOCK_NAME = 'iakpress/iakfield-sliderrange';


    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::RANGE_MIN_DEFAULT,
                Option::LABEL => self::MIN_VALUE_LABEL,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::RANGE_MAX_DEFAULT,
                Option::LABEL => self::MAX_VALUE_LABEL,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $this->addOption(
            SliderBaseType::createSliderMinOption(0, 0)
        );

        $this->addOption(
            SliderBaseType::createSliderMaxOption(0, 0)
        );

        $this->addOption(
            SliderBaseType::createSliderStepOption(0)
        );

        PrependProps::add($this);

        InputSettingsProps::add($this);
    }
}