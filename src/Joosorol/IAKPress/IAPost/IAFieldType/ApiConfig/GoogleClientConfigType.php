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

class GoogleClientConfigType extends ApiConfigBase
{
    const TYPE = FieldRenderType::GOOGLE_CLIENT_TYPE;

    const CLIENT_ID = 'client_id';
    const REDIRECT_URI = 'redirect_uri';
    const SCOPE = 'scope';
    const ACCESS_TYPE = 'access_type';
    const STATE = 'state';
    const INCLUDE_GRANTED_SCOPES = 'include_granted_scopes';
    const LOGIN_HINT = 'login_hint';
    const PROMPT = 'prompt';

    const CLIENT_ID_LABEL = 'Client ID';
    const SCOPE_LABEL = 'Scope';
    const ACCESS_TYPE_LABEL = 'Access Type';
    const INCLUDE_GRANTED_SCOPES_LABEL = 'Granted Scopes';
    const LOGIN_HINT_LABEL = 'Login Hint';
    const PROMFT_LABEL = 'Approval Prompt';



    const CONFIG = [
        ApiConfigBase::API_KEY => [ApiConfigBase::API_KEY_LABEL, true], /** [label, isRequired] */
        ApiConfigBase::SECRET_KEY => [ApiConfigBase::SECRET_KEY_LABEL, true],
        self::CLIENT_ID => [self::CLIENT_ID_LABEL, true],
        self::SCOPE => [self::SCOPE_LABEL, false],
        self::ACCESS_TYPE => [self::ACCESS_TYPE_LABEL, true] ,
        self::INCLUDE_GRANTED_SCOPES => [self::INCLUDE_GRANTED_SCOPES_LABEL, false],
        self::LOGIN_HINT => [self::LOGIN_HINT_LABEL, false],
        self::PROMPT => [self::PROMFT_LABEL, false]
    ];

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, $setDefault);

        foreach(self::CONFIG as $optName => $optVal) {
            $this->addOption(Option::createOption([
                Option::NAME => $optName,
                Option::LABEL => $optVal[0],
                Option::RENDER_TYPE => self::BF_TEXT_RENDER_TYPE,
                Option::FIELD_TYPE => self::BF_TEXT_TYPE,
                Option::REQUIRED => $optVal[1],
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]));
        }
    }
}
