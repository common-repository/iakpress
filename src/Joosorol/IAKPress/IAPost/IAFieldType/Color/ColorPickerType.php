<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Color;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class ColorPickerType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::COLOR_PICKER_TYPE;
    const RENDER_TYPE = FieldRenderType::COLOR_RENDER_TYPE;
    const LABEL = 'Color Picker';

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
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
