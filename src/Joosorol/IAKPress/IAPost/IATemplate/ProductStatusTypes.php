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
use App\Joosorol\IAKPress\IALabel\FieldLabels;

class ProductStatusTypes {
    const DISABLED = 'disabled';
    const DISABLED_LABEL = 'Disabled';

    const AVAILABLE = 'available';
    const AVAILABLE_LABEL = 'Available';

    const UNAVAILABLE = 'unavailable';
    const UNAVAILABLE_LABEL = 'Unavailable';
   
    /**
     * Constructor
     */
    private function __construct()
    {
       
    }


    public static function getTypes() : array {
        return [
            self::DISABLED => [
                Option::VALUE => self::DISABLED,
                Option::LABEL => FieldLabels::translate(self::DISABLED, self::DISABLED_LABEL)
            ],
            
            self::AVAILABLE => [
                Option::VALUE => self::AVAILABLE,
                Option::LABEL => FieldLabels::translate(self::AVAILABLE, self::AVAILABLE_LABEL)
            ],
            
            self::UNAVAILABLE => [
                Option::VALUE =>self::UNAVAILABLE,
                Option::LABEL => FieldLabels::translate(self::UNAVAILABLE, self::UNAVAILABLE_LABEL)
            ]
        ];
    }
}