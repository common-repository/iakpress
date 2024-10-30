<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;

abstract class ModelDefaultTemplate extends BaseTemplate
{
    public function getDefaultFields(): array
    {
        return array_merge(
            [
                [
                    Option::NAME => Option::TITLE,
                    Option::LABEL => FieldLabels::translate(Option::TITLE),
                    Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                    Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                    Option::REQUIRED => true,
                    Option::UNIQUE => true,
                    Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
                ]
            ],
            
            
            $this->doGetDefaultFields()
        );
    }

    protected function doGetDefaultFields(): array
    {
        return array();
    }

    public function getReadMore() {
        return FieldLabels::translate(Option::READ_MORE);
    }
}
