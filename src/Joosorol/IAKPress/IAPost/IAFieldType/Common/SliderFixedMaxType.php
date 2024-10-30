<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;


class SliderFixedMaxType extends SliderBaseType {
    const TYPE = AbstractFieldType::SLIDER_FIXED_MAX_TYPE;
    const RENDER_TYPE = AbstractFieldType::SLIDER_RENDER_TYPE;

    const FIXED_MAX_POST_CONFIG_TITLE = 'Range Max';
    const BLOCK_NAME = 'iakpress/iakfield-sliderfixedmax';

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
            SliderBaseType::createSliderValueOption(0)
        );

        $this->addOption(
            SliderBaseType::createSliderMinOption(0, 0)
        );

        $this->addOption(
            SliderBaseType::createSliderMaxOption(0, 0)
        );

        PrependProps::add($this);

        InputSettingsProps::add($this);
    }
}