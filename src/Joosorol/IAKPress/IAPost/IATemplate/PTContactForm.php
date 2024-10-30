<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IALabel\LabelKey;
use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class PTContactForm extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_CONTACT_FORM;
    const NAME = 'contactform';
    const TITLE_TEXT = 'Contact Form';
    const HELP_TEXT = 'Receive messages from your website visitors.';
    
    const READ_MORE_TEXT = 'Learn more';
    
    const SAVE_BTN = 'save_btn';

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
                Option::NAME => Option::TITLE,
                Option::LABEL => FieldLabels::translate(LabelKey::SUBJECT,  'Subject'),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::REQUIRED => true,
                Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::EMAIL,
                Option::LABEL => FieldLabels::translate(LabelKey::SUBJECT,  'Email'),
                Option::FIELD_TYPE => FieldRenderType::BF_EMAIL_TYPE,
                Option::REQUIRED => true,
                Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::DESC,
                Option::LABEL => FieldLabels::translate(LabelKey::MESSAGE,  'Message'),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXTAREA_TYPE,
                Option::REQUIRED => true,
                Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => self::SAVE_BTN,
                Option::LABEL => FieldLabels::translate(LabelKey::SUBMIT,  'Submit'),
                Option::FIELD_TYPE => FieldRenderType::FORM_BTN_SUBMIT_TYPE,
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