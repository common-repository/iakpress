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

class SelectCartButtonType extends CartButtonBaseType
{
    const TYPE = FieldRenderType::SELECT_CART_BTN_TYPE;
    const RENDER_TYPE = FieldRenderType::CART_BTN_RENDER_TYPE;
    const FIELD_TYPE = Option::FIELD_TYPE;

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => self::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => CartButtonType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new CartButtonType (CartButtonType::TYPE, array(), false));

            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectCartButtonType::TYPE] = (new SelectCartButtonType())->toArray();
        $fieldTypes[CartButtonType::TYPE] = (new CartButtonType())->toArray();
    }
}
