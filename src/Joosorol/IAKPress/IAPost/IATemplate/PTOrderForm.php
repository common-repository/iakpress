<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IATemplate\IASection\SignUpSection;

class PTOrderForm extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_ORDER_FORM;
    const NAME = 'orderform';
    const TITLE_TEXT = 'Order Form';
    const HELP_TEXT = '';
    
    const READ_MORE_TEXT = '';
    
    /**
     * Constructor
     * @param string $name
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE); 
    }

    public function getDefaultFields(): array
    {
        return  [
            self::getMainSectionFieldConfig(),
            [
                Option::NAME => Option::USERNAME,
                Option::LABEL => FieldLabels::translate(Option::USERNAME),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::REQUIRED => true,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Constants::TOTAL_PRICE,
                Option::LABEL => FieldLabels::translate(Constants::TOTAL_PRICE,  "Total price"),
                Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                Option::REQUIRED => true,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Constants::TRANSACTION_ID,
                Option::LABEL => FieldLabels::translate(Constants::TRANSACTION_ID,  "Trasanction ID"),
                Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                Option::SECTION_NAME => Option::MAIN_SECTION
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
        return 'address.png';
    }
}