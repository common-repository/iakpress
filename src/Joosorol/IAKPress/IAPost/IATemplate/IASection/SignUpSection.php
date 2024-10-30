<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate\IASection;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\Constants;

class SignUpSection {
    const SIGN_UP_BTN = 'sign_up_btn';

    const LOG_IN_BTN = 'log_in_btn';

    const RESET_PASSWORD_BTN = 'reset_password_btn';

    const CHANGE_PASSWORD_BTN = 'change_password_btn';

    const MODIFY_PROFIL_BTN = 'modify_profil_btn';


    public static function getConfig(string $sectionName): array
    {
        return  [
            [
                Option::NAME => Option::USERNAME,
                Option::SHORT_NAME => Option::USERNAME,
                Option::LABEL => FieldLabels::translate(Option::USERNAME),
                Option::REQUIRED => true,
                Option::DELETABLE => 'false',
                Option::UNIQUE => true,
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => Option::EMAIL,
                Option::SHORT_NAME => Option::EMAIL,
                Option::LABEL => FieldLabels::translate(Option::EMAIL),
                Option::REQUIRED => true,
                Option::DELETABLE => 'false',
                Option::UNIQUE => true,
                Option::FIELD_TYPE => FieldRenderType::BF_EMAIL_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => Option::PASSWORD,
                Option::SHORT_NAME => Option::PASSWORD,
                Option::LABEL => FieldLabels::translate(Option::PASSWORD),
                Option::PATTERN => Constants::PASSWORD_REGEX,
                Option::FORMAT_MSG => FieldLabels::translate(Option::PASSWORD_ERROR_MSG),
                Option::REQUIRED => true,
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::BF_PASSWORD_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => Option::REMEMBER_ME,
                Option::SHORT_NAME => Option::REMEMBER_ME,
                Option::LABEL => FieldLabels::translate(Option::REMEMBER_ME),
                Option::REQUIRED => false,
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],


            [
                Option::NAME => Option::NEW_PASSWORD,
                Option::SHORT_NAME => Option::NEW_PASSWORD,
                Option::LABEL => FieldLabels::translate(Option::NEW_PASSWORD),
                Option::PATTERN => Constants::PASSWORD_REGEX,
                Option::FORMAT_MSG => FieldLabels::translate(Option::PASSWORD_ERROR_MSG),
                Option::REQUIRED => true,
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::BF_PASSWORD_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => Option::CONFIRM_PASSWORD,
                Option::SHORT_NAME => Option::CONFIRM_PASSWORD,
                Option::LABEL => FieldLabels::translate(Option::CONFIRM_PASSWORD),
                Option::PATTERN => Constants::PASSWORD_REGEX,
                Option::FORMAT_MSG => FieldLabels::translate(Option::PASSWORD_ERROR_MSG),
                Option::REQUIRED => true,
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::BF_PASSWORD_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => self::SIGN_UP_BTN,
                Option::SHORT_NAME => self::SIGN_UP_BTN,
                Option::LABEL => FieldLabels::translate(Option::SIGN_UP),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::FORM_BTN_SIGN_UP_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => self::LOG_IN_BTN,
                Option::SHORT_NAME => self::LOG_IN_BTN,
                Option::LABEL => FieldLabels::translate(Option::LOG_IN),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::FORM_BTN_LOG_IN_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => self::RESET_PASSWORD_BTN,
                Option::SHORT_NAME => self::RESET_PASSWORD_BTN,
                Option::LABEL => FieldLabels::translate(Option::RESET_PASSWORD),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::FORM_BTN_RESET_PASSWORD_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => self::CHANGE_PASSWORD_BTN,
                Option::SHORT_NAME => self::CHANGE_PASSWORD_BTN,
                Option::LABEL => FieldLabels::translate(Option::CHANGE_PASSWORD),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::FORM_BTN_CHANGE_PASSWORD_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => self::MODIFY_PROFIL_BTN,
                Option::SHORT_NAME => self::MODIFY_PROFIL_BTN,
                Option::LABEL => FieldLabels::translate(Option::MODIFY_PROFIL),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::FORM_BTN_MODIFY_PROFIL_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],


            [
                Option::NAME => Option::SIGN_UP_ADMIN_NOTIF,
                Option::SHORT_NAME => Option::SIGN_UP_ADMIN_NOTIF,
                Option::LABEL => FieldLabels::translate(Option::SIGN_UP_ADMIN_NOTIF),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::ACTION_SIGN_UP_ADMIN_NOTIFICATION_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => Option::SIGN_UP_USER_NOTIF,
                Option::SHORT_NAME => Option::SIGN_UP_USER_NOTIF,
                Option::LABEL => FieldLabels::translate(Option::SIGN_UP_USER_NOTIF),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::ACTION_SIGN_UP_USER_NOTIFICATION_TYPE,
                Option::SECTION_NAME =>$sectionName
            ],

            [
                Option::NAME => Option::RESET_PASSWORD_NOTIF,
                Option::SHORT_NAME => Option::RESET_PASSWORD_NOTIF,
                Option::LABEL => FieldLabels::translate(Option::RESET_PASSWORD_NOTIF),
                Option::DELETABLE => 'false',
                Option::FIELD_TYPE => FieldRenderType::ACTION_RESET_PASSWORD_NOTIFICATION_TYPE,
                Option::SECTION_NAME =>$sectionName
            ]
        ];
    }
}