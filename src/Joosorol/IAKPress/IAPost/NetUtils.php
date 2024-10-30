<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost;

/**
 * class NetUtils
 */
class NetUtils {
    /**
     * Constructor.
     */
    private function __construct() {
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * 2Checkout IP Networks
     * 91.220.121.0/25
     * 5.35.210.128/25
     * 184.106.7.192/29
     * 85.17.14.128/27
     * 162.221.60.0/22
     */
    public static function is2CheckoutIPAddr($ip) {	  
        if (self::startsWith($ip,  '91.220.121.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.255.128'));

            return $subnet === '91.220.121.0';
        } else if (self::startsWith($ip,  '5.35.210.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.255.128'));

            return $subnet === '5.35.210.128';
        } else if (self::startsWith($ip,  '184.106.7.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.255.248'));

            return $subnet === '184.106.7.192';
        } else if (self::startsWith($ip,  '85.17.14.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.255.224'));

            return $subnet === '85.17.14.128';
        } else if (self::startsWith($ip,  '162.221.60.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.252.0'));

            return $subnet === '162.221.60.0';
		 } else if (self::startsWith($ip,  '162.221.61.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.252.0'));

            return $subnet === '162.221.60.0';
		 } else if (self::startsWith($ip,  '162.221.62.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.252.0'));

            return $subnet === '162.221.60.0';
		 } else if (self::startsWith($ip,  '162.221.63.')) {
            $subnet = long2ip( ip2long($ip) & ip2long('255.255.252.0'));

            return $subnet === '162.221.60.0';
        } else {
            return false;
        }
    }
}

/* EOF */