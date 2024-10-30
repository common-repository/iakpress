<?php

/*
 * This file is part of iacaboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleListWithImages;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFEmailType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFIntegerType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFNumericType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFPasswordType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFSlugType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextareaType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFUrlType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Checkbox\BasicCheckboxType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Choice\ChoiceCheckboxGroupType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Choice\ChoiceRadioGroupType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Choice\ChoiceSimpleSelectType;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderBaseType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderRangeType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Media\MediaImageType;

class ChoiceGroupFieldPostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_CHOICE_GROUP_FIELD_POST_TYPE;
    const NAME = Constants::IA_CHOICE_GROUP_FIELD_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_CHOICE_GROUP_FIELD_POST_TYPE;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_CONFIG_TYPE); 

        $this->addField(
            Option::createOption([
                 Option::FIELD_TYPE => FieldRenderType::OPTION_SIMPLE_SELECT_TYPE,
                 Option::NAME => Option::FIELD_TYPE,
                 Option::REQUIRED => true,
                 Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                 Option::DEFAULT_VALUE => SimpleListWithImages::TYPE_VALUE
             ])
             ->addSimpleSubOption(0, '')
             ->addSimpleSubOption(BFTextType::TYPE, BFTextType::LABEL)
             ->addSimpleSubOption(BFTextareaType::TYPE, BFTextareaType::LABEL)
             ->addSimpleSubOption(BFEmailType::TYPE, BFEmailType::LABEL)
             ->addSimpleSubOption(BFPasswordType::TYPE, BFPasswordType::LABEL)
             ->addSimpleSubOption(BFUrlType::TYPE, BFUrlType::LABEL)
             ->addSimpleSubOption(BFIntegerType::TYPE, BFIntegerType::LABEL)
             ->addSimpleSubOption(BFNumericType::TYPE, BFNumericType::LABEL)

             ->addSimpleSubOption(BasicCheckboxType::TYPE, BasicCheckboxType::LABEL)
             ->addSimpleSubOption(MediaImageType::TYPE, MediaImageType::LABEL)

             ->addSimpleSubOption(ChoiceSimpleSelectType::TYPE, ChoiceSimpleSelectType::LABEL)
             ->addSimpleSubOption(ChoiceRadioGroupType::TYPE, ChoiceRadioGroupType::LABEL)
             ->addSimpleSubOption(ChoiceCheckboxGroupType::TYPE, ChoiceCheckboxGroupType::LABEL)
         );

         $this->addField(Option::createOption([
            Option::NAME => Option::MODEL_ID,
            Option::REQUIRED => true,
            Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
            Option::FIELD_TYPE => Option::OPTION_GENERIC_MODEL_TYPE,
        ]));

        $this->addField(
            new BFSlugType(
                Option::NAME,
                [
                    Option::REQUIRED => true,
                    Option::UNIQUE => true,
                    Option::MIN_LENGTH => 2,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );

         $this->addField(
            new BFTextType(
                Option::LABEL,
                [
                    Option::REQUIRED => true,
                    Option::UNIQUE => true,
                    Option::MIN_LENGTH => 2,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                Option::ERROR_MSG,
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
                ],
                false
            )
        );

        $this->addField(
            new SliderRangeType(
                Option::MIN_MAX_LENGTH,
                [
                    Option::RANGE => SliderBaseType::RANGE,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MIN_DEFAULT => 0,
                    Option::RANGE_MAX => 500,
                    Option::RANGE_MAX_DEFAULT => 500,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        $this->addField(
            Option::createOption([
                Option::NAME => Option::REQUIRED,
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME => Option::UNIQUE,
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );
    }

    public function getLabel() {
        return 'ChoiceGroup Fields';
    }
}