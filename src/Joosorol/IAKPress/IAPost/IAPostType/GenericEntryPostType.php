<?php

/*
 * This file is part of iacaboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IAPost\Constants;

class GenericEntryPostType extends SubPostType {
    const POST_TYPE = Constants::IA_GENERIC_ENTRY_POST_TYPE;
    CONST NAME = Constants::IA_GENERIC_ENTRY_POST_TYPE;

    const VALUE = 'value';
    const VALUE_LABEL = 'Value';

    const PARENT = Constants::PARENT_NODE;
    const PARENT_LABEL = 'Parent';

    const LIST = 'list';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_TYPE); 
    }

    public function getLabel() {
        return 'Entry';
    }
}