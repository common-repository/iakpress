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

class SimpleProductList extends BaseTemplate
{
    const TYPE_VALUE = TemplateTypes::FT_MODEL_SIMPLE_PRODUCT_LIST;
    const NAME = 'simple-product-list';
    const TITLE_TEXT = 'Product List';
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

    public function getDefaultFields(): array
    {
        return [
            [
                Option::NAME => Option::TITLE,
                Option::LABEL => FieldLabels::translate(Option::LABEL),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                Option::REQUIRED => true,
                Option::UNIQUE => true,
                Option::MIN_LENGTH => Option::MIN_LENGTH
            ],

            [
                Option::NAME => Option::REGULAR_PRODUCT_PRICE,
                Option::LABEL => FieldLabels::translate(Option::REGULAR_PRODUCT_PRICE),
                Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                Option::REQUIRED => false,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => self::FILE_PATH,
                Option::LABEL => FieldLabels::translate(Option::THUMBNAIL_IMAGE),
                Option::FIELD_TYPE => FieldRenderType::MEDIA_UPLOAD_IMAGE_TYPE,
                Option::TYPE => FieldRenderType::SELECT_MEDIA_TYPE,
                Option::REQUIRED => true,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ],

            [
                Option::NAME => Option::DESC,
                Option::LABEL => FieldLabels::translate(Option::DESC),
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::REQUIRED => false,
                Option::MIN_LENGTH => Option::MIN_LENGTH
            ],
            
            [
                Option::NAME => Option::MENU_ORDER,
                Option::LABEL => FieldLabels::translate(Option::MENU_ORDER),
                Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                Option::REQUIRED => false,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]
        ];
    }

    protected function doGetDefaultFields(): array
    {
        return array();
    }

    public function getIcon() {
        return '';
    }
}
