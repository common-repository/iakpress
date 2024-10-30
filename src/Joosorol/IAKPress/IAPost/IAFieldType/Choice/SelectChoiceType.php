<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Choice;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\ChoiceListProps;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleListWithImages;
use App\Joosorol\IAKPress\IAPost\IATemplate\HierarchicalListWithImages;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleList;
use App\Joosorol\IAKPress\IAPost\IATemplate\HierarchicalList;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleProductList;

class SelectChoiceType extends ChoiceBase
{
    const TYPE = FieldRenderType::SELECT_CHOICE_TYPE;
    const RENDER_TYPE = FieldRenderType::CHOICE_RENDER_TYPE;


    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => ChoiceSimpleSelectType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
            ]);

            $option->addSubOption(new ChoiceImageListType (ChoiceImageListType::TYPE, array()));

            $option->addSubOption(new ChoiceCheckboxGroupType (ChoiceCheckboxGroupType::TYPE, array()));
            $option->addSubOption(new ChoiceRadioGroupType(ChoiceRadioGroupType::TYPE, array()));
            $option->addSubOption(new ChoiceSimpleSelectType(ChoiceSimpleSelectType::TYPE, array()));

            $option->addSubOption(new ChoiceCascadingCheckboxGroupType(ChoiceCascadingCheckboxGroupType::TYPE, array()));
            $option->addSubOption(new ChoiceCascadingRadioGroupType(ChoiceCascadingRadioGroupType::TYPE, array()));
            $option->addSubOption(new ChoiceCascadingSimpleSelectType(ChoiceCascadingSimpleSelectType::TYPE, array()));


            $option->addSubOption(new ChoiceProductListType (ChoiceProductListType::TYPE, array()));
            $option->addSubOption(new ChoiceMenuListType (ChoiceMenuListType::TYPE, array()));
            $option->addSubOption(new ChoiceCategoryListType (ChoiceCategoryListType::TYPE, array()));
            $option->addSubOption(new ChoiceTagListType (ChoiceTagListType::TYPE, array()));
            $option->addSubOption(new ChoiceColorListType (ChoiceColorListType::TYPE, array()));
            $option->addSubOption(new ChoiceCustomListType (ChoiceCustomListType::TYPE, array()));

            $this->addOption($option);

            $this->addOption(Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SIMPLE_SELECT_TYPE,
                Option::NAME => Option::MODEL_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => SimpleList::TYPE_VALUE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
            ->addSimpleSubOption(SimpleList::TYPE_VALUE, SimpleList::TITLE_TEXT)
            ->addSimpleSubOption(SimpleListWithImages::TYPE_VALUE, SimpleListWithImages::TITLE_TEXT)
            ->addSimpleSubOption(SimpleProductList::TYPE_VALUE, SimpleProductList::TITLE_TEXT)
            ->addSimpleSubOption(HierarchicalList::TYPE_VALUE, HierarchicalList::TITLE_TEXT)
            ->addSimpleSubOption(HierarchicalListWithImages::TYPE_VALUE, HierarchicalListWithImages::TITLE_TEXT));

            parent::setDefaultOptions();

            ChoiceListProps::add($this);
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public function getImg()
    {
        return 'paper.svg';
    }


    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectChoiceType::TYPE] = (new SelectChoiceType())->toArray();
        $fieldTypes[ChoiceCheckboxGroupType::TYPE] = (new ChoiceCheckboxGroupType())->toArray();
        $fieldTypes[ChoiceRadioGroupType::TYPE] = (new ChoiceRadioGroupType())->toArray();
        $fieldTypes[ChoiceSimpleSelectType::TYPE] = (new ChoiceSimpleSelectType())->toArray();
        $fieldTypes[ChoiceCascadingCheckboxGroupType::TYPE] = (new ChoiceCascadingCheckboxGroupType())->toArray();
        $fieldTypes[ChoiceCascadingRadioGroupType::TYPE] = (new ChoiceCascadingRadioGroupType())->toArray();
        $fieldTypes[ChoiceCascadingSimpleSelectType::TYPE] = (new ChoiceCascadingSimpleSelectType())->toArray();

        $fieldTypes[ChoiceImageListType::TYPE] = (new ChoiceImageListType())->toArray();
        $fieldTypes[ChoiceProductListType::TYPE] = (new ChoiceProductListType(ChoiceProductListType::TYPE, array(), true))->toArray();
        $fieldTypes[ChoiceMenuListType::TYPE] = (new ChoiceMenuListType())->toArray();
        $fieldTypes[ChoiceCategoryListType::TYPE] = (new ChoiceCategoryListType())->toArray();
        $fieldTypes[ChoiceTagListType::TYPE] = (new ChoiceTagListType())->toArray();
        $fieldTypes[ChoiceColorListType::TYPE] = (new ChoiceColorListType())->toArray();
        $fieldTypes[ChoiceCustomListType::TYPE] = (new ChoiceCustomListType(ChoiceCustomListType::TYPE, array(), true))->toArray();
    }
}
