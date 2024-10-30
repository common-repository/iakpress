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
use App\Joosorol\IAKPress\IAPost\AbstractPostType;

abstract class SubPostType extends AbstractPostType {
    const POST_CONFIG_PARENT_ID = 'parent_id';
    const POST_CONFIG_PARENT_TITLE = 'parent_title';

    const ID = Option::ID;
    const TITLE = Option::TITLE;
    const DAFAULT_TITLE = 'default_title';
    const TITLE_LABEL = 'Name';
    const CONTENT = 'content';
    const CONTENT_EXCERPT = 'content_excerpt';
    const NAME = Option::NAME;
    const INTRO = 'intro';
    const CREATED_AT = 'created_at';
    const CREATED_AT_GMT = 'created_at_gmt';
    const UPDATED_AT = 'updated_at';
    const UPDATED_AT_GMT = 'updated_at_gmt';
    const USER_ID = 'user_id';
    const FIELD_ID = 'field_id';
    const MENU_ORDER = Option::MENU_ORDER;
    const INTERNAL_ID = 'internal_id';
    const EDIT_LOCK = '_edit_lock';
    const EDIT_LAST = '_edit_last';
    /**
     * Constructor
     * @param $formType
     */
    public function __construct($formType)
    {
        parent::__construct($formType); 
        
        $this->addField(
            new BFTextType(
                self::TITLE,
                [
                    Option::LABEL => self::TITLE_LABEL,
                    Option::REQUIRED => true,
                    Option::MIN_LENGTH => 2,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );
    }
}