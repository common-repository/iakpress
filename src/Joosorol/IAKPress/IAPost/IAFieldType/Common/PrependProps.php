<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;

class PrependProps
{

    private function __construct()
    {
    }

    public static function add(AbstractFieldType &$field)
    {

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::BEFORE_TEXT,
                Option::RENDER_TYPE => AbstractFieldType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );

        $field->addOption(
            Option::createOption([
                Option::NAME => Option::AFTER_TEXT,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
            ])
        );
    }
}
