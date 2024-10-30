<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class BFEmailType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::BF_EMAIL_TYPE;
    const RENDER_TYPE = FieldRenderType::BF_TEXT_RENDER_TYPE;
    const LABEL = 'Email';

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
            false);
        
        if ($setDefault) {
            ValidationProps::add($this);
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
