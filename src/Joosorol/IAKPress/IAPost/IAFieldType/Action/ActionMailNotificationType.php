<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Action;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class ActionMailNotificationType extends ActionTypeBase
{
    const TYPE = FieldRenderType::ACTION_MAIL_NOTIFICATION_TYPE;
    const RENDER_TYPE = FieldRenderType::ACTION_RENDER_TYPE;
    const LABEL = 'Mail Notification';

    const FROM_ADDRESS = 'mail_from_addr';
    const FROM_ADDRESS_LABEL = 'From Address';

    const FROM_LABEL = 'mail_from_label';
    const FROM_LABEL_LABEL = 'From Label';

    const TO = 'mail_to';
    const TO_LABEL = 'To';

    const CC = 'mail_cc';
    const CC_LABEL = 'CC';

    const BCC = 'mail_bcc';
    const BCC_LABEL = 'BCC';

    const SUBJECT = 'mail_subject';
    const SUBJECT_LABEL = 'Subject';

    const API_LABEL = 'SMTP Api';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct(
            $name,
            self::TYPE,
            array_merge(
                [
                    Option::LABEL => self::LABEL,
                ],
                $attrs),
            $setDefault);
        
        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        $this->addOption(
            Option::createOption([
                Option::NAME => self::FROM_LABEL,
                Option::LABEL => self::FROM_LABEL_LABEL,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => self::FROM_ADDRESS,
                Option::LABEL => self::FROM_ADDRESS_LABEL,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => self::TO,
                Option::LABEL => self::TO_LABEL,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_TYPE => FieldRenderType::BF_EMAIL_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                Option::PLACEHOLDER => 'admin_email'
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => self::CC,
                Option::LABEL => self::CC_LABEL,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::FIELD_TYPE => FieldRenderType::OPTION_EMAIL_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );


        /*$this->addOption(
            Option::createOption([
                Option::NAME => self::BCC,
                Option::LABEL => self::BCC_LABEL,
                Option::HIDE => false,
                Option::FIELD_TYPE => FieldRenderType::BF_EMAIL_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );*/

        $this->addOption(
            Option::createOption([
                Option::NAME => self::SUBJECT,
                Option::LABEL => self::SUBJECT_LABEL,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => self::BODY,
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::LABEL => self::BODY_LABEL,
                Option::HIDE => false,
                Option::RENDER_TYPE => FieldRenderType::CONTENT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS
            ])
        );
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
