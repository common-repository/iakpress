<?php

/*
 * This file is part of iakboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IAPost\Constants;

class FieldPostType extends SubPostType {
    const POST_TYPE = Constants::IA_FIELD_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_FIELD_POST_TYPE;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_CONFIG_TYPE); 
    }

    public function getLabel() {
        return 'Field';
    }
}