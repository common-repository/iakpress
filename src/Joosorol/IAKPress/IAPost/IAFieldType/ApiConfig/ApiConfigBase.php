<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\ApiConfig;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class ApiConfigBase extends AbstractFieldType
{
    const RENDER_TYPE = FieldRenderType::API_CONFIG_RENDER_TYPE;
    const LABEL = 'Config Field';

    const API_KEY = 'api_key';
    const API_KEY_LABEL = 'API Key';

    const SECRET_KEY = 'secret_key';
    const SECRET_KEY_LABEL = 'Secret Key';


    public function __construct($name, $type, array $attrs = array(), $setDefault = true)
    {
        parent::__construct(
            $name,
            $type,
            array_merge(
                [
                    Option::LABEL => self::LABEL
                ],
                $attrs
            ),
            $setDefault
        );

        $this->addOption(Option::createOption([
            Option::NAME => Option::ENABLED,
            Option::RENDER_TYPE => FieldRenderType::CHECKBOX_RENDER_TYPE,
            Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
            Option::REQUIRED => false,
            Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
        ]));
    }


    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
