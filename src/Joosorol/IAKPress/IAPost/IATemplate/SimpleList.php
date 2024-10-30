<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SimpleList extends ModelDefaultTemplate {
    const TYPE_VALUE = TemplateTypes::FT_MODEL_SIMPLE_LIST;
    const NAME = 'simple-list';
    const TITLE_TEXT = 'Simple List';
    const HELP_TEXT = '';
    
    const READ_MORE_TEXT = 'Learn more';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE); 
    }

    protected function doGetDefaultFields(): array
    {
        return   [
            [
                Option::NAME => Option::PRICE_VALUE,
                Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                Option::REQUIRED => false
            ],

            [
                Option::NAME => Option::MENU_ORDER,
                Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                Option::REQUIRED => false
            ]
        ];
    }

    public function getName() {
        return self::NAME;
    }
    
    public function getTitle() {
        return self::TITLE_TEXT;
    }
    
    public function getHelp() {
        return self::HELP_TEXT;
    }

    public function getTextLines() : array {
        return [];
    }

    public function getReadMoreUrl() {
        return '';
    }

    public function getReadMore() {
        return self::READ_MORE_TEXT;
    }

    public function getIcon() {
        return '';
    }
}
