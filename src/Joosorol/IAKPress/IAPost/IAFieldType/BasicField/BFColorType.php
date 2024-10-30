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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class BFColorType  extends BasicFieldTypeBase {
    const TYPE = AbstractFieldType::BF_COLOR_TYPE;
    const RENDER_TYPE = AbstractFieldType::BF_COLOR_RENDER_TYPE;
    const LABEL = 'Color';

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

    public function getRenderType(): string {
        return self::RENDER_TYPE;
    }
}
