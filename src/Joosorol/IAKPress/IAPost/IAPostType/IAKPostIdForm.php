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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\SmartField\SFPostConfigTitleType;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;

class IAKPostIdForm extends AbstractPostType {
    const POST_TYPE = Constants::IAK_POST_ID_FORM_POST_TYPE;
    CONST NAME = Constants::IAK_POST_ID_FORM_POST_TYPE;
    const LABEL = 'IAKPost ID';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::NAME); 

        $this->addField(
            new SFPostConfigTitleType(
                Constants::IAKPOST_ID,
                [
                    Option::LABEL => Constants::IAKPOST_ID_LABEL,
                    Option::REQUIRED => false,
                    Option::HIDE_LABEL => true,
                    Option::MIN_LENGTH => 2,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );
    }
    
    public function getLabel() {
        return self::LABEL;
    }
}