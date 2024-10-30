<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\ApiConfig;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SmtpApiConfigType extends ApiConfigBase
{
    const TYPE = FieldRenderType::SMTP_API_TYPE;

    const HOST = 'host';
    const HOST_LABEL = 'Host';

    const PORT = 'port';
    const PORT_LABEL = 'Port';

    const USERNAME = 'username';
    const USERNAME_LABEL = 'Username';

    const PASSWORD = Option::PASSWORD;
    const PASSWORD_LABEL = 'Password';

    const SECURE = 'secure';
    const SECURE_LABEL = 'SMTPSecure';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, $setDefault);

        // Host
        $this->addOption(Option::createOption([
            Option::NAME => self::HOST,
            Option::LABEL => self::HOST_LABEL,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
            Option::PLACEHOLDER => "The hostname of the mail server",
            Option::REQUIRED => true,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
        ]));

        // Port
        $this->addOption(Option::createOption([
            Option::NAME => self::PORT,
            Option::LABEL => self::PORT_LABEL,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
            Option::PLACEHOLDER => "The SMTP port number",
            Option::REQUIRED => true,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
        ]));

        // Username
        $this->addOption(Option::createOption([
            Option::NAME => self::USERNAME,
            Option::LABEL => self::USERNAME_LABEL,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
            Option::PLACEHOLDER => "Username to use for SMTP authentication",
            Option::REQUIRED => true,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
        ]));

        // Password
        $this->addOption(Option::createOption([
            Option::NAME => self::PASSWORD,
            Option::LABEL => self::PASSWORD_LABEL,
            Option::RENDER_TYPE => FieldRenderType::BF_PASSWORD_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_PASSWORD_TYPE,
            Option::PLACEHOLDER => "Password to use for SMTP authentication",
            Option::REQUIRED => true,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
        ]));

         // Password
         $this->addOption(Option::createOption([
            Option::NAME => self::SECURE,
            Option::LABEL => self::SECURE_LABEL,
            Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
            Option::PLACEHOLDER => "The encryption system to user (ex tls)",
            Option::REQUIRED => true,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
        ]));
    }
}
