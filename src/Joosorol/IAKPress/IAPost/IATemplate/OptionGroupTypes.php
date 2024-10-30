<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class OptionGroupTypes {
    /**
     * Constructor
     */
    private function __construct()
    {
       
    }


    public static function getTypes() : array {
        return [
            Option::OPT_GROUP_CUSTOM => [
                Option::VALUE => Option::OPT_GROUP_CUSTOM,
                Option::LABEL => ''
            ],

            Option::OPT_GROUP_COLOR => [
                Option::VALUE => Option::OPT_GROUP_COLOR,
                Option::LABEL => FieldLabels::translate(Option::OPT_GROUP_COLOR)
            ],

            Option::OPT_GROUP_SIZE => [
                Option::VALUE => Option::OPT_GROUP_SIZE,
                Option::LABEL => FieldLabels::translate(Option::OPT_GROUP_SIZE)
            ]
        ];
    }
}