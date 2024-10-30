<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\SmartField;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SelectSFType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::SELECT_SF_TYPE;
    const RENDER_TYPE = FieldRenderType::SF_RENDER_TYPE;
 
    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => SFPostConfigTitleType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);
   

            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SFPostConfigTitleType::TYPE] = (new SFPostConfigTitleType())->toArray();

        $fieldTypes[SelectSFType::TYPE] = (new SelectSFType())->toArray();
    }
}
