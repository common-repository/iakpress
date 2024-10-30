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
use App\Joosorol\IAKPress\IALabel\LabelKey;

class ProductList extends BaseTemplate
{
    const TYPE_VALUE = TemplateTypes::FT_MODEL_PRODUCT_LIST;
    const NAME = 'product-list';
    const TITLE_TEXT = 'Product List';
    const HELP_TEXT = '';

    const READ_MORE_TEXT = 'Learn more';


    const IMG_LIST = 'img_list';

   /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE);
    }

    public function getName()
    {
        return Option::NAME;
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
    

    private function getGeneralSectionConfig() : array {
        return  [
            [
                Option::NAME => Option::MAIN_SECTION,
                Option::LABEL => FieldLabels::translate(Option::MAIN_SECTION),
                Option::FIELD_TYPE => FieldRenderType::CONTAINER_BASIC_SECTION_TYPE,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_PRODUCT_GENERAL_SECTION_TYPE,
                Option::MENU_ORDER => 0
            ],

            [
                Option::NAME => Option::DISABLED,
                Option::LABEL => FieldLabels::translate(Option::DISABLE_PRODUCT),
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::REQUIRED => false,
                Option::SECTION_NAME => Option::MAIN_SECTION,
            ],

            [
                Option::NAME => Option::FEATURED,
                Option::LABEL => FieldLabels::translate(Option::FEATURED),
                Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                Option::REQUIRED => false,
                Option::SECTION_NAME => Option::MAIN_SECTION,
            ],


            [
                Option::NAME => Option::TITLE,
                Option::LABEL => FieldLabels::translate(Option::NAME),
                Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                Option::REQUIRED => true,
                Option::UNIQUE => true,
                Option::MIN_LENGTH => Option::MIN_LENGTH,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::REGULAR_PRODUCT_PRICE,
                Option::LABEL => FieldLabels::translate(Option::REGULAR_PRODUCT_PRICE),
                Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                Option::REQUIRED => false,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::FILE_PATH,
                Option::LABEL => FieldLabels::translate(Option::THUMBNAIL_IMAGE),
                Option::FIELD_TYPE => FieldRenderType::MEDIA_UPLOAD_IMAGE_TYPE,
                Option::REQUIRED => false,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::PRIMARY_CATEGORY,
                Option::LABEL => FieldLabels::translate(LabelKey::CATEGORIES),
                Option::REQUIRED => false,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_CATEGORY_LIST,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ],

            [
                Option::NAME => Option::TAG,
                Option::LABEL => FieldLabels::translate(Option::TAG),
                Option::REQUIRED => false,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_TAG_LIST,
                Option::SECTION_NAME => Option::MAIN_SECTION
            ]
        ];
    }

    private function getDescSectionConfig() : array {
        return  [
            [
                Option::NAME => Option::DESC_SECTION,
                Option::LABEL => FieldLabels::translate(Option::DESCRIPTION),
                Option::FIELD_TYPE => FieldRenderType::CONTAINER_BASIC_SECTION_TYPE,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_PRODUCT_DESC_SECTION_TYPE,
                Option::MENU_ORDER => 1
            ],
            [
                Option::NAME => Option::DESC,
                Option::LABEL => FieldLabels::translate(Option::FULL_DESC),
                Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                Option::REQUIRED => false,
                Option::HIDE_LABEL => true,
                Option::ROWS => 10,
                Option::MIN_LENGTH => Option::MIN_LENGTH,
                Option::SECTION_NAME => Option::DESC_SECTION
            ]
        ];
    }

    private function getGallerySectionConfig() : array {
        return  [
            [
                Option::NAME => Option::GALLERY_SECTION,
                Option::LABEL => FieldLabels::translate(Option::PHOTO_GALLERY),
                Option::FIELD_TYPE => FieldRenderType::CONTAINER_BASIC_SECTION_TYPE,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_PHOTO_GALLERY_TYPE,
                Option::MENU_ORDER => 3
            ]
        ];
    }

    private function getLinkedProdSectionConfig() : array {
        return  [
            [
                Option::NAME => Option::LINKEDPROD_SECTION,
                Option::LABEL => FieldLabels::translate(Option::LINKEDPROD_SECTION,  'Linked Products'),
                Option::FIELD_TYPE => FieldRenderType::CONTAINER_BASIC_SECTION_TYPE,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_LINKED_PRODUCT_TYPE,
                Option::MENU_ORDER => 4
            ]
        ];
    }


    private function  getProdVariantSectionConfig() : array {
        return  [
            [
                Option::NAME => Option::PRODVARIANT_SECTION,
                Option::LABEL => FieldLabels::translate(Option::PRODVARIANT_SECTION,  'Variations'),
                Option::FIELD_TYPE => FieldRenderType::CONTAINER_BASIC_SECTION_TYPE,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_PRODUCT_VARIANT_TYPE,
                Option::MENU_ORDER => 5
            ],

            [
                Option::NAME => Option::OPTIONGROUP,
                Option::LABEL => FieldLabels::translate(Option::OPTIONGROUPS),
                Option::REQUIRED => false,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_OPTION_GROUP_LIST,
                Option::SECTION_NAME => Option::PRODVARIANT_SECTION
            ]
        ];
    }

    public function getDefaultFields(): array
    {
        return array_merge(
            $this->getGeneralSectionConfig(),
            $this->getDescSectionConfig(),
            $this->getProdVariantSectionConfig(),
            $this->getGallerySectionConfig(),
            $this->getLinkedProdSectionConfig()
        );
    }

    protected function doGetDefaultFields(): array
    {
        return array();
    }

    public function getReadMore() {
        return FieldLabels::translate(Option::READ_MORE);
    }

    public function getIcon() {
        return '';
    }
}
