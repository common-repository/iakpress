<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\StepperButton;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SelectStepperButtonType extends StepperButtonTypeBase
{
    const TYPE = FieldRenderType::SELECT_STEPPER_BUTTON_TYPE;
    const RENDER_TYPE = FieldRenderType::STEPPER_BUTTON_RENDER_TYPE;
    const ICON = 'fas fa-columns';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
            ]);

            $option->addSubOption(new StepperButtonNextType (StepperButtonNextType::TYPE, array(), false));
            $option->addSubOption(new StepperButtonPreviousType (StepperButtonPreviousType::TYPE, array(), false));

            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectStepperButtonType::TYPE] = (new SelectStepperButtonType())->toArray();
        $fieldTypes[StepperButtonNextType::TYPE] = (new StepperButtonNextType())->toArray();
        $fieldTypes[StepperButtonPreviousType::TYPE] = (new StepperButtonPreviousType())->toArray();
    }
}
