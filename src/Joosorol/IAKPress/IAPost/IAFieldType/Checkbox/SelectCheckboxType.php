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

class SelectCheckboxType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::SELECT_CHECKBOX_TYPE;
    const RENDER_TYPE = FieldRenderType::CHECKBOX_RENDER_TYPE;
    const ICON = 'fa fa-check';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => BasicCheckboxType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new BasicCheckboxType (BasicCheckboxType::TYPE, array(), false));
      
            $this->addOption($option);

            parent::setDefaultOptions();

            $this->addOption(
                Option::createOption([
                    Option::NAME => Option::CONTENT,
                    Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                    Option::HIDE => false,
                    Option::RENDER_TYPE => FieldRenderType::CONTENT_RENDER_TYPE,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
                ])
            );
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public function getImg()
    {
        return 'check.svg';
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectCheckBoxType::TYPE] = (new SelectCheckBoxType())->toArray();
        $fieldTypes[BasicCheckboxType::TYPE] = (new BasicCheckboxType())->toArray();
    }
}
