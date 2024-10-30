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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class PTProductListViewForm extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_PRODUCT_LIST_VIEW_FORM;
    const NAME = 'orderform';
    const TITLE_TEXT = 'Product List';
    const HELP_TEXT = 'Build a product list in minutes and start sell your products.';
    
    const READ_MORE_TEXT = 'Learn more';

    const STORE_ADDRESS = 'store_addr';
    const CART = 'cart';

    const STORE_TERMS = 'store_terms';
    const STORE_CONTACT_US = 'store_contact_us';
    const STORE_ACCOUNT = 'store_account';

    /**
     * Constructor
     * @param string $name
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE); 
    }

    public function getDefaultFields(): array
    {
        return  [
            self::getMainSectionFieldConfig(FieldRenderType::DECORATOR_PRODUCT_ITEM_TYPE),

            [
                Option::NAME => Option::CUSTOM_LIST,
                Option::LABEL => FieldLabels::translate(Option::PRODUCT_LIST),
                Option::REQUIRED => false,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_PRODUCT_LIST,
                Option::SECTION_NAME => Option::MAIN_SECTION,
                Option::ITEMS_PER_ROW => 4,
                Option::ITEMS_PER_PAGE => 20,
                Option::ITEMS_MIN_HEIGHT => 160,
            ]
        ];
    }


    public function getName() {
        return self::NAME;
    }
    
    public function getTitle() {
        return self::TITLE_TEXT;
    }
    
    public function getHelp() {
        return self::HELP_TEXT;
    }

    public function getTextLines() : array {
        return [];
    }

    public function getReadMoreUrl() {
        return '';
    }

    public function getReadMore() {
        return self::READ_MORE_TEXT;
    }

    public function getIcon() {
        return 'ico_create_quizz.png';
    }
}