<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\CartButton;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IALabel\FieldLabels;

class CartButtonType extends CartButtonBaseType
{
    const TYPE = FieldRenderType::CART_BTN_TYPE;
    const RENDER_TYPE = FieldRenderType::CART_BTN_RENDER_TYPE;

    const CART = 'cart';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct(
            $name,
            self::TYPE,
            array_merge(
                [
                    Option::LABEL => FieldLabels::translate(self::CART, 'Cart')
                ],
                $attrs
            ),
            false
        );
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
