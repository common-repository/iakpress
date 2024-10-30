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

class PostRequestData  {    
    const FIELD_LIST = 'fieldList';
    const VALUE_MAP = 'valueMap';
    const ORDER_LIST = 'orderList';

    const INTERNAL_ID_KEY = 'internalId';
    const TEMPLATE_ID_KEY = 'templateId';

    const INTERNAL_ID = 'internal_id';
    const FIELD_TYPE = 'type';
    const SLIDER_TYPE_KEY = SelectSliderType::SLIDER_TYPE_KEY;

    /**
     * @var array
     */
    private $formData = array();

    /**
     * @var array
     */
    private $requestValues;

    /**
     * Constructor
     * @param string $args
     */
    public function __construct(array $args)
    {
        $this->requestValues = $args;
        
        $fieldList = $args[self::FIELD_LIST] ?? null;

        if ($fieldList != null && is_array($fieldList)) {
            $orderListData = $fieldList[self::ORDER_LIST] ?? array();
            if ($orderListData != null && is_array($orderListData)) {
                // set fields order list
                $this->formData[self::ORDER_LIST] = $orderListData;

                // merge fields with ordering info
                $valueMap = $fieldList[self::VALUE_MAP] ?? null;
                if ($valueMap != null && is_array($valueMap)) {
                    $newValueMap = array();

                    foreach ($orderListData as $order) {
                        $internalId = $order[self::INTERNAL_ID_KEY] ?? '0';
                        $templateId = intval($order[self::TEMPLATE_ID_KEY] ?? '0');
                        $fieldAttrs = $valueMap[$order[self::INTERNAL_ID_KEY]] ?? null;

                        
                        if ($fieldAttrs && is_array($fieldAttrs)) {
                            $newValueMap[$internalId] =
                                array_merge(
                                    $fieldAttrs,
                                    [
                                        self::INTERNAL_ID => $internalId,
                                        self::FIELD_TYPE => $templateId // templateId == field type
                                    ]
                                );
                        }
                    }

                    $this->formData[self::VALUE_MAP] = $newValueMap;
                }
            }
        }
    }

    

    /**
     * Get current request values
     * @return array
     */
    public function getRequestValues() : array {
        return $this->requestValues;
    }

    /**
     * Get formData
     * @return array
     */
    public function getPostData() : array {
        return $this->formData;
    }

    /**
     * Get formData orderList
     * @return array
     */
    public function getPostOrderList() : array {
        return  $this->formData[self::ORDER_LIST] ?? array();
    }

    

    public function setPostOrderList(array $orderList) {
        $this->formData[self::ORDER_LIST] = $orderList;
    }
    

     /**
     * Get formData value map
     * @return array
     */
    public function getPostValueMap() : array {
        return  $this->formData[self::VALUE_MAP] ?? array();
    }

    /**
     * Set formData value map
     * @param array valueMap
     */
    public function setPostValueMap(array $valueMap) {
        $this->formData[self::VALUE_MAP] = $valueMap;
    }
}