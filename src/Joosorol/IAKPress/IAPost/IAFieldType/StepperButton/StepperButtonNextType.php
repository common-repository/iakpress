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

class StepperButtonNextType extends StepperButtonTypeBase
{
    const TYPE = FieldRenderType::STEPPER_BUTTON_BTN_NEXT_TYPE;
    const RENDER_TYPE = FieldRenderType::STEPPER_BUTTON_RENDER_TYPE;
    const LABEL = 'Next Button';
    const BLOCK_NAME = 'iakpress/iakfield-nextbtn';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct(
            $name,
            self::TYPE,
            array_merge(
                [
                    Option::LABEL => self::LABEL
                ],
                $attrs),
            $setDefault);
        
        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
