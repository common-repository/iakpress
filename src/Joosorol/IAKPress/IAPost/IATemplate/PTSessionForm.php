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

class PTSessionForm extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_SESSION_FORM;
    const NAME = 'sessionform';
    const TITLE_TEXT = 'Session Form';
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
                Option::SECTION_NAME =>Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::EMAIL,
                Option::LABEL => FieldLabels::translate(Option::EMAIL),
                Option::FIELD_TYPE => FieldRenderType::BF_EMAIL_TYPE,
                Option::SECTION_NAME =>Option::MAIN_SECTION
            ],

            [
                Option::NAME => Constants::IP_ADDRESS,
                Option::LABEL => FieldLabels::translate(Constants::IP_ADDRESS,  "IP address"),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::SECTION_NAME =>Option::MAIN_SECTION
            ],

            [
                Option::NAME => Constants::USER_AGENT,
                Option::LABEL => FieldLabels::translate(Constants::USER_AGENT,  "User agent"),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::SECTION_NAME =>Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::DESC,
                Option::LABEL => FieldLabels::translate(Constants::SESSION_VALUE,  'Session value'),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXTAREA_TYPE,
                Option::SECTION_NAME =>Option::MAIN_SECTION
            ],

            [
                Option::NAME => Constants::SESSION_EXPIRY,
                Option::LABEL => FieldLabels::translate(Constants::SESSION_EXPIRY,  'Session expiry'),
                Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                Option::SECTION_NAME =>Option::MAIN_SECTION
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