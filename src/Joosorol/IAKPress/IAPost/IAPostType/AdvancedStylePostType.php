<?php

/*
 * This file is part of iakboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\ListItemCssClasses;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;

class AdvancedStylePostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_ADVANCED_STYLE_POST_TYPE;
    CONST NAME = Constants::IA_ADVANCED_STYLE_POST_TYPE;

    const OPTION_NAME_PREFIX = 'p';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_TYPE); 
        
        $this->addField(
            new BFTextType(
                self::buildOptionName(Option::POST_CONFIG_BODY_CLASS),
                [
                    Option::LABEL => FieldLabels::translate(Option::POST_CONFIG_BODY_CLASS),
                    Option::REQUIRED => false,
                    Option::MIN_LENGTH => 2,
                    Option::PLACEHOLDER => '.iak-body',
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::ROW_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::ROW_CLASS),
                Option::PLACEHOLDER => '.iak-row',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::LABELGROUP_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::LABELGROUP_CLASS),
                Option::PLACEHOLDER => '.iak-label-group',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::LABEL_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::LABEL_CLASS),
                Option::PLACEHOLDER => '.iak-label',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );


        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::INPUTGROUP_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::INPUTGROUP_CLASS),
                Option::PLACEHOLDER => '.iak-input-group',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::INPUT_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::INPUT_CLASS),
                Option::PLACEHOLDER => '.iak-input',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::SECTION_ROW_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::SECTION_ROW_CLASS),
                Option::PLACEHOLDER => '.iak-section-row',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::SECTION_LABEL_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::SECTION_LABEL_CLASS),
                Option::PLACEHOLDER => '.iak-section-label',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME =>  self::buildOptionName(Option::SECTION_INPUT_CLASS),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::LABEL => FieldLabels::translate(Option::SECTION_INPUT_CLASS),
                Option::PLACEHOLDER => '.iak-section-input',
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ])
        );

        foreach(ListItemCssClasses::CSS_CLASSES as $fieldName => $val) {
            $this->addField(
                Option::createOption([
                    Option::NAME =>  $fieldName,
                    Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                    Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                    Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                    Option::LABEL => $val[0],
                    Option::PLACEHOLDER => $val[1],
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
                ])
            );
        }

    }

    public function getLabel() {
        return FieldLabels::translate(Option::ADVANCED_STYLE);
    }

    public static function buildOptionName($name) {
        return sprintf("%s_%s", self::OPTION_NAME_PREFIX, $name);
    }
}