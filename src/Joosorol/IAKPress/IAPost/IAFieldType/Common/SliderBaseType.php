<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;


abstract class SliderBaseType extends AbstractFieldType {
    const RENDER_TYPE = AbstractFieldType::SLIDER_RENDER_TYPE;

    const SLIDER_CONFIG_DATA = 'slider_data';
    const SLIDER_CONFIG_TYPE = Option::FIELD_TYPE;
    const RANGE = 'range';
    const RANGE_LABEL = 'Range';
    const RANGE_DEFAULT = 'Default';
    
    const RANGE_MIN = Option::RANGE_MIN;
    const RANGE_MIN_LABEL = 'Range Min';
    const RANGE_MIN_LONG_LABEL = 'Range with fixed minimum';


    const RANGE_MAX = Option::RANGE_MAX;
    const RANGE_MAX_LABEL = 'Range Max';
    const RANGE_MAX_LONG_LABEL = 'Range with fixed maximum';

    const RANGE_RANGE = Option::RANGE_RANGE;
    const RANGE_RANGE_LABEL = 'Range';
    const RANGE_RANGE_LONG_LABEL = 'Range Slider';

    
    CONST RANGE_STEP = Option::RANGE_STEP;
    CONST RANGE_STEP_LABEL = 'Range Step';
    CONST RANGE_STEP_LONG_LABEL = 'Snap to increments';

    const ORIENTATION = 'orientation';
    const ORIENTATION_LABEL = 'Orientation';
    const ORIENTATION_LONG_LABEL = 'Orientation';
    const ORIENTATION_VERTICAL = 'vertical';


    public function __construct($name, $type, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, $type, $attrs, $setDefault);
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);

        RowLayoutProps::add($this);

        GeneralLayoutProps::add($this);
    }

    public function getRenderType(): string {
        return self::RENDER_TYPE;
    }

    public static function createSliderMinOption($initialMin, $min) {
        $subOption = Option::createOption([
            Option::NAME => self::RANGE_MIN,
            Option::REQUIRED => true,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
        ]);

        $subOption->setInitialValue($initialMin);
        $subOption->setValue($min);

        return $subOption;
    }

    public static function setSliderMinOption($option, $initialMin, $min) {
        $subOption = self::createSliderMinOption($initialMin, $min);
        $option->addSubOption($subOption);
    }

    public static function createSliderMaxOption($initialMax, $max) {
        $subOption = Option::createOption([
            Option::NAME => self::RANGE_MAX,
            Option::REQUIRED => true,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
        ]);
        
        $subOption->setInitialValue($initialMax);
        $subOption->setValue($max);
       return $subOption;
    }

    
    public static function setSliderMaxOption($option, $initialMax, $max) {
        $subOption = self::createSliderMaxOption($initialMax, $max);
        $option->addSubOption($subOption);
    }

    public static function createSliderValueOption($value) {
        $subOption = Option::createOption([
            Option::NAME => Option::VALUE,
            Option::REQUIRED => true,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            Option::VALUE => $value
        ]);


        return $subOption;
    }

    public static function setSliderValueOption($option, $range) {
        $subOption = self::createSliderValueOption($range);
        $option->addSubOption($subOption);
    }

    public static function createSliderStepOption($step) {
        $subOption = Option::createOption([
            Option::NAME => self::RANGE_STEP,
            Option::REQUIRED => true,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
        ]);

        $subOption->setValue($step);
        return $subOption;
    }

    public static function setSliderStepOption($option, $step) {
        $subOption = self::createSliderStepOption($step);
        $option->addSubOption($subOption);
    }

    public static function setSliderValue($option, $value) {
        $option->setValue($value);
    }

    public static function setSliderInitialValue($option, $value) {
        $option->setInitialValue($value);
    }
}