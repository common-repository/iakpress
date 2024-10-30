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

class PTCustomListViewForm extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_CUSTOM_LIST_VIEW_FORM;
    const NAME = 'customlist';
    const TITLE_TEXT = 'Custom List';
    const HELP_TEXT = 'Create a dynamic, searchable list for your custom posts.';
    
    const READ_MORE_TEXT = 'Learn more';

    const CUSTOM_LIST = 'custom_list';
    
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
            [
                Option::NAME => Option::MAIN_SECTION,
                Option::LABEL => FieldLabels::translate(Option::MAIN_SECTION,  Option::MAIN_SECTION),
                Option::FIELD_TYPE => FieldRenderType::CONTAINER_BASIC_SECTION_TYPE,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_CUSTOM_LIST_ITEM_TYPE,
            ],

            [
                Option::NAME => self::CUSTOM_LIST,
                Option::LABEL => FieldLabels::translate(Option::CUSTOM_LIST, 'Custom List'),
                Option::REQUIRED => false,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_CUSTOM_LIST,
                Option::SECTION_NAME => Option::MAIN_SECTION,
                Option::ITEMS_PER_ROW => 4,
                Option::ITEMS_PER_PAGE => 20,
                Option::ITEMS_MIN_HEIGHT => 160
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