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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;


class BFUrlType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::BF_URL_TYPE;
    const RENDER_TYPE = FieldRenderType::BF_URL_RENDER_TYPE;
    const LABEL = 'URL';

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
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
