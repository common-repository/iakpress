<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\TextEditor;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\RowLayoutProps;

abstract class TextEditorBase extends AbstractFieldType
{
    const CONTENT = Option::CONTENT;

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

        $this->addOption (
            Option::createOption([
                Option::NAME => self::CONTENT,
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::LABEL =>  FieldLabels::translate(Option::CONTENT),
                Option::HIDE => false,
                Option::HIDE_LABEL => true,
                Option::PLACEHOLDER =>  FieldLabels::translate(Option::CONTENT),
                Option::RENDER_TYPE => FieldRenderType::CONTENT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );

        RowLayoutProps::add($this);
    }
}
