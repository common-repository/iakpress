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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Choice\ChoiceSimpleSelectType;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;

class ContactPostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_CONTACT_POST_TYPE;
    CONST NAME = Constants::IA_CONTACT_POST_TYPE;
    const LABEL = 'ContactForm';
    

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::NAME); 

        $this->addField(
            new ChoiceSimpleSelectType(
                Option::ENTRY_TITLE,
                [
                    Option::REQUIRED => false,
                    Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE
                ],
                false
            )
        );

        $this->addField(
            new ChoiceSimpleSelectType(
                Option::ENTRY_CONTENT,
                [
                    Option::REQUIRED => false,
                    Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE
                ],
                false
            )
        );
    }
    
    public function getLabel() {
        return self::LABEL;
    }
}