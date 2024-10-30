<?php

/*
 * This file is part of iakboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SelectSliderType;


const SLIDER_TYPE_KEY = SelectSliderType::SLIDER_TYPE_KEY;

class PostFields extends AbstractPostType {
    const POST_TYPE = Constants::IA_FIELD_POST_TYPE;
    
    const FIELD_LIST = 'fieldList';
    const VALUE_MAP = 'valueMap';
    const ORDER_LIST = 'orderList';
    const ORDER_LIST_LABEL = 'OrderList';
    const POST_CONFIG_CONFIG_KEY = 'formConfig';
    const VALUES_KEY = 'values';
    const MIN_POST_CONFIG_TITLE_LEN = 4;

    const FIELD_ID = 'id';
    const FIELD_PARENT_ID = 'parent_id';
    const FIELD_LABEL = 'label';
    const FIELD_NAME = 'name';
    const FIELD_DATA = 'data';
    const FIELD_CONFIG_OPT = 'fieldConfigOpt';

    const INTERNAL_ID_KEY = 'internalId';
    const TEMPLATE_ID_KEY = 'templateId';

    const INTERNAL_ID = 'internal_id';
    const TEMPLATE_ID = 'template_id';
    const TYPE = 'type';
    const FIELD_TYPE = 'field_type';
    const SLIDER_TYPE_KEY = SelectSliderType::SLIDER_TYPE_KEY;


    /**
     * Constructor
     * @param string $args
     */
    public function __construct($type, $attrs = array())
    {
        parent::__construct($type, $attrs);
    }
}