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

class SelectApiConfigType extends ApiConfigBase
{
    const TYPE = FieldRenderType::SELECT_API_CONFIG_TYPE;
 
    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => SmtpApiConfigType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new SmtpApiConfigType(SmtpApiConfigType::TYPE, array(), false));
            $option->addSubOption(new StripeApiConfigType(StripeApiConfigType::TYPE, array(), false));
            $option->addSubOption(new SmtpApiConfigType(SmtpApiConfigType::TYPE, array(), false));
            $option->addSubOption(new PaypalApiConfigType(PaypalApiConfigType::TYPE, array(), false));

            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }



    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[GoogleClientConfigType::TYPE] = (new GoogleClientConfigType())->toArray();
        $fieldTypes[StripeApiConfigType::TYPE] = (new StripeApiConfigType())->toArray();
        $fieldTypes[SelectApiConfigType::TYPE] = (new SelectApiConfigType())->toArray();
        $fieldTypes[SmtpApiConfigType::TYPE] = (new SmtpApiConfigType())->toArray();
        $fieldTypes[PaypalApiConfigType::TYPE] = (new PaypalApiConfigType())->toArray();
    }
}
