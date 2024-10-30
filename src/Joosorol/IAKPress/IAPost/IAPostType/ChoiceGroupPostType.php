<?php

/*
 * This file is part of iacaboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleListWithImages;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleList;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFSlugType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IATemplate\SimpleProductList;

class ChoiceGroupPostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_GENERIC_MODEL_POST_TYPE;
    const NAME = Constants::IA_GENERIC_MODEL_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_GENERIC_MODEL_POST_TYPE;

    const VALUE = 'value';
    const VALUE_LABEL = 'Value';

    const PARENT = Constants::PARENT_NODE;
    const PARENT_LABEL = 'Parent';


    const TYPE = Option::POST_CONFIG_TYPE;
    const TYPE_LABEL = 'Type';

    const LIST = 'list';
    
    const CHILDREN = Constants::CHILDREN;

    const DESCRIPTION = 'Description';

    const HIERARCHY = 'hierarchy';
    const HIERARCHY_LABEL = 'Hierarchy';

    const GROUP_LABEL = 'Name';

    const ITEM_CATEGORIES_GROUP = 'item_categories_group';
    const ITEM_CATEGORIES_GROUP_LABEL = 'Item Categories Group';

    const ITEM_COLORS_GROUP = 'item_colors_group';
    const ITEM_COLORS_GROUP_LABEL = 'Item Colors Group';

    const ITEM_SIZES_GROUP = 'item_sizes_group';
    const ITEM_SIZES_GROUP_LABEL = 'Item Sizes Group';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_CONFIG_TYPE); 

        $this->addField(
            Option::createOption([
                 Option::FIELD_TYPE => FieldRenderType::OPTION_SIMPLE_SELECT_TYPE,
                 Option::NAME => self::TYPE,
                 Option::LABEL => self::TYPE_LABEL,
                 Option::REQUIRED => true,
                 Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                 Option::DEFAULT_VALUE => SimpleListWithImages::TYPE_VALUE,
                 Option::PLACEHOLDER => 'Select data list type',
             ])
             ->addSimpleSubOption(0, 'Select data list type')
             ->addSimpleSubOption(SimpleList::TYPE_VALUE, SimpleList::TITLE_TEXT)
             ->addSimpleSubOption(SimpleListWithImages::TYPE_VALUE, SimpleListWithImages::TITLE_TEXT)
             ->addSimpleSubOption(SimpleProductList::TYPE_VALUE, SimpleProductList::TITLE_TEXT)
         );


         $this->addField(
            new BFTextType(
                Option::TITLE,
                [
                    Option::LABEL => self::GROUP_LABEL,
                    Option::REQUIRED => true,
                    Option::UNIQUE => true,
                    Option::MIN_LENGTH => 2,
                    Option::PLACEHOLDER => 'Data list name',
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );


        $this->addField(
            new BFSlugType(
                Option::CPT_NAME,
                [
                    Option::REQUIRED => true,
                    Option::MIN_LENGTH => 2,
                    Option::PLACEHOLDER => 'CPT slug'
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                Option::CPT_VIEW_ID,
                [
                    Option::REQUIRED => false,
                    Option::HIDE => true,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );
    }

    public function getLabel() {
        return 'Choice Groups';
    }
}