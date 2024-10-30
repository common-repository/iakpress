<?php

/*
 * This file is part of iakboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;

class LicensePostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_LICENCE_POST_TYPE;
    CONST NAME = Constants::IA_LICENCE_POST_TYPE;

    const PUBLIC_KEY = 'public_key';
    const PRIVATE_KEY = 'private_key';
    const HOSTNAME = 'hostname';
    const SITE_URL = 'site_url';


    const PUBLIC_KEY_LABEL = 'Public Key';
    const PRIVATE_KEY_LABEL = 'Private Key';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_TYPE);

        $this->addField(
            new BFTextType(
                self::PUBLIC_KEY,
                [
                    Option::LABEL => self::PUBLIC_KEY_LABEL,
                    Option::REQUIRED => true,
                    Option::MIN_LENGTH => 2,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                self::PRIVATE_KEY,
                [
                    Option::LABEL => self::PRIVATE_KEY_LABEL,
                    Option::REQUIRED => true,
                    Option::MIN_LENGTH => 2,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );
    }

    public function getLabel() {
        return 'License';
    }

    public static function generateHashWithSalt($password) {
        return hash("sha256", $password);
    }
}