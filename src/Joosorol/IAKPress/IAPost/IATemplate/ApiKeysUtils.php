<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class ApiKeysUtils {
    const TITLE_FIELD = Option::TITLE;
	const DESC_FIELD = Option::DESC;
	
	public static function getTemplate($modelType) : ?PTApiKeysConfig {
        switch ($modelType) {
        case  TemplateTypes::FT_GOOGLE_CLIENT:
            return new PTApiGoogleClient();

        case  TemplateTypes::FT_STRIPE_API:
            return new PTApiStripe();
    
        case  TemplateTypes::FT_SMTP_API:
            return new PTApiSmtp();

        case  TemplateTypes::FT_PAYPAL_API:
            return new PTApiPaypal();

        default:
            return null;
        }
    }

    public static function getSupports($type) : array {
        $modelTpl = self::getTemplate($type);

        return array('title');
    }
}
