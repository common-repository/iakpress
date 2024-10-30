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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;

class SimpleListWithImages extends SimpleList
{
    const TYPE_VALUE = TemplateTypes::FT_MODEL_SIMPLE_LIST_WITH_IMAGES;
    const NAME = 'simple-list-with-images';
    const TITLE_TEXT = 'Simple List with images';
    const HELP_TEXT = '';

    const READ_MORE_TEXT = '';

    const FILE_PATH = Option::FILE_PATH;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE);
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getTitle()
    {
        return self::TITLE_TEXT;
    }

    public function getHelp()
    {
        return self::HELP_TEXT;
    }

    public function getTextLines(): array
    {
        return [];
    }

    public function getReadMoreUrl()
    {
        return '';
    }

    public function getReadMore()
    {
        return self::READ_MORE_TEXT;
    }

    protected function doGetDefaultFields(): array
    {
        $res =  [
            [
                Option::NAME => self::FILE_PATH,
                Option::LABEL => FieldLabels::translate(Option::THUMBNAIL_IMAGE),
                Option::FIELD_TYPE => FieldRenderType::MEDIA_UPLOAD_IMAGE_TYPE,
                Option::TYPE => FieldRenderType::SELECT_MEDIA_TYPE,
                Option::REQUIRED => true,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ],

            
            [
                Option::NAME => Option::MENU_ORDER,
                Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                Option::REQUIRED => false
            ]
        ];

        return $res;
    }

    public function getIcon() {
        return '';
    }
}
