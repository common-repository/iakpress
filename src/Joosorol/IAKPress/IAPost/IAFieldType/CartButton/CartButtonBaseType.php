<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\CartButton;

use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Color\ColorPaletteType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IATemplate\PTApiStripe;

abstract class CartButtonBaseType extends AbstractFieldType
{

    const SECONDARY_LABEL = 'slabel';
    const TERTIARY_LABEL = 'tlabel';

    const SELECT_BTN_LBL = 'add_to_cart';
    const SUBMIT_BTN_LBLS = 'buy_now';

    const PURCHASE_NOTE = 'purchase_note';

    const PAYMENT_OPTIONS = 'payment_options';

    public function __construct($name, $type, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, $type, $attrs);

        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);

        $this->addOption(
            new BFTextType(
                self::SECONDARY_LABEL,
                [
                    Option::LABEL =>  FieldLabels::translate(self::SECONDARY_LABEL, 'Secondary label'),
                    Option::PLACEHOLDER => FieldLabels::translate(self::SELECT_BTN_LBL, 'Add to cart'),
                    Option::REQUIRED => true,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );

        $this->addOption(
            new BFTextType(
                self::TERTIARY_LABEL,
                [
                    Option::LABEL =>  FieldLabels::translate(self::TERTIARY_LABEL, 'Tertiary label'),
                    Option::PLACEHOLDER => FieldLabels::translate(self::SUBMIT_BTN_LBLS, 'Buy now'),
                    Option::REQUIRED => true,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => self::PAYMENT_OPTIONS,
                Option::FIELD_TYPE => FieldRenderType::OPTION_CHECKBOX_GROUP_TYPE,
                Option::FIELD_LAYOUT => FieldRenderType::TOP_ALIGNED_LABELS_TYPE,
                Option::LABEL => FieldLabels::translate(self::PAYMENT_OPTIONS, 'Payment Options'),
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
            ->addSimpleSubOption(PTApiStripe::NAME, PTApiStripe::TITLE_TEXT)
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => self::PURCHASE_NOTE,
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::LABEL => FieldLabels::translate(self::PURCHASE_NOTE, 'Purchase note'),
                Option::HIDE => false,
                Option::HIDE_LABEL => true,
                Option::RENDER_TYPE => FieldRenderType::CONTENT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );       


        $this->addOption(
            new ColorPaletteType(
                Option::ITEMS_TEXT_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES
                ],
                false
            )
        );


        $this->addOption(
            new ColorPaletteType(
                Option::ITEMS_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES
                ],
                false
            )
        );

        $this->addOption(
            new ColorPaletteType(
                Option::ITEMS_BORDER_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES
                ],
                false
            )
        );

        $this->addOption(
            new ColorPaletteType(
                Option::ITEMS_HOVER_BG_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES
                ],
                false
            )
        );

        $this->addOption(
            new ColorPaletteType(
                Option::ITEMS_HOVER_TEXT_COLOR,
                [
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES
                ],
                false
            )
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::ROW_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::PLACEHOLDER => Option::CSS_CLASS,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::INPUT_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::PLACEHOLDER => Option::CSS_CLASS,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::LABEL_CLASS,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::PLACEHOLDER => Option::CSS_CLASS,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::HIDE_LABEL,
                Option::FIELD_TYPE => FieldRenderType::BF_CHECKBOX_TYPE,
                Option::VALUE => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
            ])
        );
    }
}
