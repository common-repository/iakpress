<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;

use App\Joosorol\IAKPress\IAPost\IAPostType\LicensePostType;
use App\Joosorol\IAKPress\IAPost\Constants;

class LicenseModel
{ 
    /**
     * @var LicenseModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * LicenseModel Constructor.
     */
    private function __construct()
    {
    }


    /**
     * Main LicenseModel Instance
     *
     * Ensures only one instance of LicenseModel is loaded or can be loaded.
     *
     * @static
     * @return LicenseModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function update(array $values)
    {
       $publicKey = $values[LicensePostType::PUBLIC_KEY] ?? '';
       $pcode = $values[Constants::LICENSE_PCODE] ?? '';
       $license_exp = $values[Constants::LICENSE_EXP] ?? '';

       update_option( Constants::IAKPRESS_KEY, $publicKey, true );
       update_option( Constants::IAKPRESS_PCODE, $pcode, true );
       update_option( Constants::IAKPRESS_LICENSE_EXP, $license_exp, true );

       
       return $values;
    }
}
