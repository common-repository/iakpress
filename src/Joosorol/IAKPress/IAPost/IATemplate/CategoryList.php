<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IALabel\FieldLabels;

class  CategoryList extends BaseTemplate
{
    const TYPE_VALUE = TemplateTypes::FT_MODEL_CATEGORY_LIST;
    const NAME = 'category-list';
    const TITLE_TEXT = 'Category List';
    const HELP_TEXT = '';

    const READ_MORE_TEXT = 'Learn more';

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
    

    public function getDefaultFields(): array
    {
        return array_merge(
            [
                [
                    Option::NAME => Option::FEATURED,
                    Option::LABEL => FieldLabels::translate(Option::FEATURED),
                    Option::FIELD_TYPE => FieldRenderType::CHECKBOX_TYPE,
                    Option::REQUIRED => false,
                    Option::SECTION_NAME => Option::MAIN_SECTION,
                ],

                [
                    Option::NAME => Option::TITLE,
                   Option::LABEL => FieldLabels::translate(Option::TITLE),
                    Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                    Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                    Option::REQUIRED => true,
                    Option::UNIQUE => true,
                    Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH
                ],
                
                [
                    Option::NAME => Option::SLUG,
                    Option::LABEL => FieldLabels::translate(Option::SLUG),
                    Option::FIELD_TYPE => FieldRenderType::BF_SLUG_TYPE,
                    Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                    Option::REQUIRED => false,
                    Option::UNIQUE => true,
                    Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH
                ],

                [
                    Option::NAME => Option::DESC,
                    Option::LABEL => FieldLabels::translate(Option::DESC),
                    Option::FIELD_TYPE => FieldRenderType::CONTENT_INPUT_PARAGRAPH,
                    Option::REQUIRED => false,
                    Option::MIN_LENGTH => BaseTemplate::MIN_LENGTH
                ]
            ],
            
            $this->doGetDefaultFields(),

            [
                [
                    Option::NAME => Option::MENU_ORDER,
                    Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                    Option::REQUIRED => false,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
                ]
            ]
        );
    }

    protected function doGetDefaultFields(): array
    {
        return array();
    }

    public function getReadMore() {
        return self::READ_MORE_TEXT;
    }

    public function getIcon() {
        return '';
    }
}
