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

class PaypalApiConfigType extends ApiConfigBase
{
    const TYPE = FieldRenderType::PAYPAL_API_TYPE;

    const CLIENT_ID = 'client_id';
    const CLIENT_ID_LABEL = 'Client ID';

    const MERCHANT_ID = 'merchant_id';
    const MERCHANT_ID_LABEL = 'Merchant ID';

    const CONFIG = [
        self::CLIENT_ID => [self::CLIENT_ID_LABEL, true] /** [label, isRequired] */,
        self::MERCHANT_ID => [self::MERCHANT_ID_LABEL, false] /** [label, isRequired] */
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
