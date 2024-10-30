<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Choice;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\GeneralLayoutProps;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\RowLayoutProps;

abstract class ChoiceBase extends AbstractFieldType
{

    const SELECT_BTN_CLASS = "select_btn_class";
    const SELECT_BTN_CLASS_LABEL = "Select button class";

    const SELECT_BTN_LBL = "select_btn_lbl";
    const SELECT_BTN_LBL_LABEL = "select_btn_lbl_label";

    const SELECT_BTN_LBL_LABEL_LABEL = "Label of Select button";

    const SELECTED_ITEMS_PAGE = "selected_items_page";
    const SELECTED_ITEMS_PAGE_LABEL = "Selected items page";

    const SUBMIT_BTN_LBL = "submit_btn_lbl";
    const SUBMIT_BTN_LBL_LABEL = "submit_btn_lbl_label";

    const SUBMIT_BTN_CLASS = "submit_btn_class";
    const SUBMIT_BTN_CLASS_LABEL = "Submit button class";

    const BUY_NOW = "buy_now";
    const LEARN_MORE = "LEARN_MORE";

    const SUBMIT_BTN_LBL_LABEL_LABEL = "Label of Submit button";

    const PREVIEW_BTN_LBL = "preview_btn_lbl";
    const PREVIEW_BTN_LBL_BTN_LABEL = "preview_btn_lbl_label";
    const PREVIEW_BTN_LBL_BTN_LABEL_LABEL = "Label of Preview button";

    const PREVIEW_BTN_CLASS = "preview_btn_class";
    const PREVIEW_BTN_CLASS_LABEL = "Preview button class";

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

        RowLayoutProps::add($this);

        GeneralLayoutProps::add($this);
    }
}
