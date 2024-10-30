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
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFIntegerType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Checkbox\BasicCheckboxType;
use App\Joosorol\IAKPress\IALabel\FieldLabels;

class LinkedProductPostType extends SubPostType {
    const POST_TYPE = Constants::IA_LINKED_PRODUCT_POST_TYPE;
    CONST NAME = Constants::IA_LINKED_PRODUCT_POST_TYPE;

    const REF_ID = 'ref_id';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_TYPE);

        $this->addField(
            new BFIntegerType(
                self::REF_ID,
                [
                    Option::LABEL => FieldLabels::translate(self::REF_ID, 'Ref ID'),
                    Option::REQUIRED => true
                ],
                false
            )
        );
    }

    public function getLabel() {
        return 'Linked Product';
    }
}