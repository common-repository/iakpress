<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SelectBFType extends BasicFieldTypeBase
{
    const TYPE = AbstractFieldType::SELECT_BF_TYPE;
    const RENDER_TYPE = AbstractFieldType::BF_TEXT_RENDER_TYPE;
    const ICON = 'fa fa-text-width';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => AbstractFieldType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => BFTextType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new BFTextType(BFTextType::TYPE, array(), false));
            $option->addSubOption(new BFTextareaType(BFTextareaType::TYPE, array(), false));
            $option->addSubOption(new BFEmailType(BFEmailType::TYPE, array(), false));
            $option->addSubOption(new BFPasswordType(BFPasswordType::TYPE, array(), false));
            $option->addSubOption(new BFUrlType(BFUrlType::TYPE, array(), false));
            $option->addSubOption(new BFIntegerType(BFIntegerType::TYPE, array()));
            $option->addSubOption(new BFNumericType(BFNumericType::TYPE, array()));

            $option->addSubOption(new BFWeight(BFWeight::TYPE, array(), false));
            $option->addSubOption(new BFPrice(BFPrice::TYPE, array(), false));
            
            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public function getImg()
    {
        return 'input.svg';
    }


    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[BFColorType::TYPE] = (new BFColorType(BFTextType::TYPE, array(), false))->toArray();
        $fieldTypes[BFEmailType::TYPE] = (new BFEmailType(BFEmailType::TYPE, array(), false))->toArray();
        $fieldTypes[BFPasswordType::TYPE] = (new BFPasswordType(BFPasswordType::TYPE, array(), false))->toArray();
        $fieldTypes[BFTelType::TYPE] = (new BFTelType(BFTelType::TYPE, array(), false))->toArray();
        $fieldTypes[BFTextType::TYPE] = (new BFTextType(BFTextType::TYPE, array(), false))->toArray();
        $fieldTypes[BFTextareaType::TYPE] = (new BFTextareaType(BFTextareaType::TYPE, array(), false))->toArray();
        $fieldTypes[BFUrlType::TYPE] = (new BFUrlType(BFUrlType::TYPE, array(), false))->toArray();
        $fieldTypes[BFMediaFileType::TYPE] = (new BFMediaFileType(BFMediaFileType::TYPE, array(), false))->toArray();
        $fieldTypes[BFSlugType::TYPE] = (new BFSlugType(BFSlugType::TYPE, array(), false))->toArray();

        $fieldTypes[BFNumericType::TYPE] = (new BFNumericType())->toArray();
        $fieldTypes[BFIntegerType::TYPE] = (new BFIntegerType())->toArray();
        $fieldTypes[BFDateTimeLocalType::TYPE] = (new BFDateTimeLocalType())->toArray();
        $fieldTypes[BFDateType::TYPE] = (new BFDateType())->toArray();
        $fieldTypes[BFMonthType::TYPE] = (new BFMonthType())->toArray();
        $fieldTypes[BFTimeType::TYPE] = (new BFTimeType())->toArray();
        $fieldTypes[BFWeekType::TYPE] = (new BFWeekType())->toArray();
        $fieldTypes[BFWeight::TYPE] = (new BFWeight())->toArray();
        $fieldTypes[BFPrice::TYPE] = (new BFPrice())->toArray();

        $fieldTypes[SelectBFType::TYPE] = (new SelectBFType())->toArray();
    }
}
