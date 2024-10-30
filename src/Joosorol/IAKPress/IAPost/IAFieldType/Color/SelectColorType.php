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

class SelectColorType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::SELECT_COLOR_TYPE;
    const RENDER_TYPE = FieldRenderType::COLOR_RENDER_TYPE;

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => ColorPaletteType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new ColorPaletteType (ColorPaletteType::TYPE, array(), false));
      
            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectColorType::TYPE] = (new SelectColorType())->toArray();
        $fieldTypes[ColorPickerType::TYPE] = (new ColorPickerType())->toArray();
        $fieldTypes[ColorPaletteType::TYPE] = (new ColorPaletteType())->toArray();
    }
}
