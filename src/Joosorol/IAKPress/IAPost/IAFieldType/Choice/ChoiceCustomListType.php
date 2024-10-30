<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Choice;

use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IALabel\FieldLabels;

class ChoiceCustomListType extends ChoiceBase
{
    const TYPE = FieldRenderType::CHOICE_CUSTOM_LIST;
    const RENDER_TYPE = FieldRenderType::CHOICE_SELECT_RENDER_TYPE;
    const LABEL = 'Custom List';

    public function __construct($name = self::TYPE, array $attrs = array(),  $setDefault = false)
    {
        parent::__construct(
            $name,
            self::TYPE,
            array_merge(
                [
                    Option::LABEL => self::LABEL
                ],
                $attrs),
            false);
            
        if ($setDefault) {
            $this->addOption(
                new BFTextType(
                    self::SELECT_BTN_LBL,
                    [
                        Option::LABEL => FieldLabels::translate(self::SELECT_BTN_LBL_LABEL, self::SELECT_BTN_LBL_LABEL_LABEL),
                        Option::PLACEHOLDER => FieldLabels::translate(self::LEARN_MORE, "Learn more"),
                        Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                    ],
                    false
                )
            );

            $this->addOption(
                new BFTextType(
                    self::SELECT_BTN_CLASS,
                    [
                        Option::LABEL => FieldLabels::translate(self::SELECT_BTN_CLASS, self::SELECT_BTN_CLASS_LABEL),
                        Option::FIELD_SECTION_ID => Option::FIELD_SECTION_STYLES,
                    ],
                    false
                )
            );
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
