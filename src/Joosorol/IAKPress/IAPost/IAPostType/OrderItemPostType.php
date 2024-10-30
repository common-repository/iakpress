<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IAPost\AbstractPostType;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class OrderItemPostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_ORDER_ITEM_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_ORDER_ITEM_POST_TYPE;
    CONST NAME = Constants::IA_ORDER_ITEM_POST_TYPE;

    
    /**
     * Constructor
     * @param string $name
     */
    public function __construct()
    {
        parent::__construct(self::POST_CONFIG_TYPE); 

        $this->addField(
            new BFTextType(
                Constants::ORDER_ID,
                [
                    Option::LABEL => FieldLabels::translate(Constants::ORDER_ID,  "Order id"),
                    Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                    Option::REQUIRED => true
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                Constants::ORDER_ITEM_ID,
                [
                    Option::LABEL => FieldLabels::translate(Constants::ORDER_ITEM_ID,  "Item id"),
                    Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                    Option::REQUIRED => true
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                Constants::ORDER_ITEM_NAME,
                [
                    Option::LABEL => FieldLabels::translate(Constants::ORDER_ITEM_NAME,  "Item name"),
                    Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                    Option::REQUIRED => true
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                Constants::ORDER_ITEM_PRICE,
                [
                    Option::LABEL => FieldLabels::translate(Constants::ORDER_ITEM_PRICE,  "Price"),
                    Option::FIELD_TYPE => FieldRenderType::BF_NUMERIC_TYPE,
                    Option::REQUIRED => true
                ],
                false
            )
        );

        $this->addField(
            new BFTextType(
                Constants::ORDER_ITEM_QTY,
                [
                    Option::LABEL => FieldLabels::translate(Constants::ORDER_ITEM_QTY,  "Quantity"),
                    Option::FIELD_TYPE => FieldRenderType::BF_INTEGER_TYPE,
                    Option::REQUIRED => true
                ],
                false
            )
        );
    }

    public function getLabel() {
        return 'Order Item';
    }
}