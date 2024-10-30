<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Checkbox;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class BasicCheckboxType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::CHECKBOX_TYPE;
    const RENDER_TYPE = FieldRenderType::CHECKBOX_RENDER_TYPE;
    const LABEL = 'Checkbox';
    const BLOCK_NAME = 'iakpress/iakfield-checkbox';

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
