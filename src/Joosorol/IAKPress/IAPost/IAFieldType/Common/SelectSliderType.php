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

class SelectSliderType extends SliderBaseType {
    const RENDER_TYPE = AbstractFieldType::SLIDER_RENDER_TYPE;
    const TYPE = AbstractFieldType::SELECT_SLIDER_TYPE;
    const SLIDER_TYPE_KEY = Option::FIELD_TYPE;
    const ICON = 'fa fa-sliders-h';


    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            
            
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => SliderBaseType::SLIDER_CONFIG_TYPE,
                Option::LABEL =>  FieldLabels::translate(Option::FIELD_TYPE),
                Option::REQUIRED => true,
                Option::RENDER_TYPE => AbstractFieldType::SELECT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);
            
            $option->addSubOption(
                Option::createOption([
                    Option::NAME => SliderBaseType::SLIDER_FIXED_MIN_TYPE,
                    Option::LABEL => SliderBaseType::RANGE_MIN_LABEL,
                    Option::RENDER_TYPE => FieldRenderType::SLIDER_RENDER_TYPE,
                    Option::FIELD_TYPE => FieldRenderType::SLIDER_FIXED_MIN_POST_CONFIG_TYPE
                ])
            );
    
            $option->addSubOption(
                Option::createOption([
                    Option::NAME => SliderBaseType::SLIDER_FIXED_MAX_TYPE,
                    Option::LABEL => SliderBaseType::RANGE_MAX_LABEL,
                    Option::LONG_LABEL => SliderBaseType::RANGE_MAX_LONG_LABEL,
                    Option::RENDER_TYPE => AbstractFieldType::SLIDER_RENDER_TYPE,
                    Option::FIELD_TYPE => FieldRenderType::SLIDER_FIXED_MAX_POST_CONFIG_TYPE
                ])
            );
            
            $option->addSubOption(
                Option::createOption([
                    Option::NAME => SliderBaseType::SLIDER_RANGE_TYPE,
                    Option::LABEL => SliderBaseType::RANGE_RANGE_LABEL,
                    Option::LONG_LABEL => SliderBaseType::RANGE_RANGE_LONG_LABEL,
                    Option::RENDER_TYPE => AbstractFieldType::SLIDER_RENDER_TYPE,
                    Option::FIELD_TYPE => FieldRenderType::SLIDER_RANGE_POST_CONFIG_TYPE
                ])
            );
            
            $option->addSubOption(
                Option::createOption([
                    Option::NAME => SliderBaseType::SLIDER_STEP_TYPE,
                    Option::LABEL => SliderBaseType::RANGE_STEP_LABEL,
                    Option::LONG_LABEL => SliderBaseType::RANGE_STEP_LONG_LABEL,
                    Option::RENDER_TYPE => AbstractFieldType::SLIDER_RENDER_TYPE,
                    Option::FIELD_TYPE => FieldRenderType::SLIDER_STEP_POST_CONFIG_TYPE
                ])
            );
    
            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }


    public function getRenderType(): string {
        return SliderBaseType::RENDER_TYPE;
    }

    public function getImg()
    {
        return 'settings.svg';
    }


    public static function createSliderMinField($name, array $fieldAttrs) {
        $min = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MIN_TYPE] ?? '0');
        $max = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MAX_TYPE] ?? '0');
        $value = intval($fieldAttrs[Option::VALUE] ?? '0');
              
        $mergedAttrs = array_merge(
            [
                Option::RANGE => Option::RANGE_MIN,
                Option::RANGE_MIN => $min,
                Option::RANGE_MIN_DEFAULT => $min,
                Option::RANGE_MAX => $max,
                Option::RANGE_MAX_DEFAULT => $max,
                Option::VALUE => $value
            ],
            $fieldAttrs
        );


        return new SliderFixedMinType($name, $mergedAttrs, false);
    }

    
    public static function createSliderMaxField($name, array $fieldAttrs) {
        $min = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MIN_TYPE] ?? '0');
        $max = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MAX_TYPE] ?? '0');
        $value = intval($fieldAttrs[Option::VALUE] ?? '0');
           
        $mergedAttrs = array_merge(
            [
                Option::RANGE => Option::RANGE_MAX,
                Option::RANGE_MIN => $min,
                Option::RANGE_MIN_DEFAULT => $min,
                Option::RANGE_MAX => $max,
                Option::RANGE_MAX_DEFAULT => $max,
                Option::VALUE => $value
            ],
            $fieldAttrs
        );


        return new SliderFixedMaxType($name, $mergedAttrs, false);

    }

    public static function createSliderStepField($name, array $fieldAttrs) {
        $min = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MIN_TYPE] ?? '0');
        $max = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MAX_TYPE] ?? '0');
        $step = intval($fieldAttrs[AbstractFieldType::SLIDER_STEP_TYPE] ?? '0');
        $value = intval($fieldAttrs[Option::VALUE] ?? '0');
 
        $mergedAttrs = array_merge(
            [
                Option::RANGE => Option::RANGE_STEP,
                Option::RANGE_MIN => $min,
                Option::RANGE_MIN_DEFAULT => $min,
                Option::RANGE_MAX => $max,
                Option::RANGE_MAX_DEFAULT => $max,
                Option::RANGE_STEP => $step,
                Option::VALUE => $value
            ],
            $fieldAttrs
        );


        return new SliderStepType($name, $mergedAttrs, false);
    }

    public static function createSliderRangeField($name, array $fieldAttrs) {
        $min = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MIN_TYPE] ?? '0');
        $min_default = intval($fieldAttrs[AbstractFieldType::SLIDER_MIN_DEFAULT] ?? '0');
        $max = intval($fieldAttrs[AbstractFieldType::SLIDER_FIXED_MAX_TYPE] ?? '0');
        $max_default = intval($fieldAttrs[AbstractFieldType::SLIDER_MAX_DEFAULT] ?? '0');
        
        
        $mergedAttrs = array_merge(
            [
                Option::RANGE => Option::RANGE_RANGE,
                Option::RANGE_MIN => $min,
                Option::RANGE_MIN_DEFAULT => $min_default,
                Option::RANGE_MAX => $max,
                Option::RANGE_MAX_DEFAULT => $max_default
            ],
            $fieldAttrs
        );


        return new SliderRangeType($name, $mergedAttrs, false);
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectSliderType::TYPE] = (new SelectSliderType())->toArray();
        $fieldTypes[SliderRangeType::TYPE] = (new SliderRangeType())->toArray();
        $fieldTypes[SliderFixedMaxType::TYPE] = (new SliderFixedMaxType())->toArray();
        $fieldTypes[SliderFixedMinType::TYPE] = (new SliderFixedMinType())->toArray();
        $fieldTypes[SliderStepType::TYPE] = (new SliderStepType())->toArray();
    }
}
