<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;

use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAPostType\OrderItemPostType;
use App\Joosorol\IAKPress\IAPost\PostConfig;

class OrderItemModel extends GenericEntryModel
{
    /**
     * @var OrderItemModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * OrderItemModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main OrderItemModel Instance
     *
     * Ensures only one instance of OrderItemModel is loaded or can be loaded.
     *
     * @static
     * @return OrderItemModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        return Constants::IA_ORDER_ITEM_POST_TYPE;
    }

    public function getUniqueFields($formConfigId, array $requestData) : array {
        return array();
    }

    public function getFieldListByModelId($modelId) : array {
        $obj = new OrderItemPostType();
        $fields = ($obj->toArray())[PostConfig::FIELDS] ?? array();
        return $fields;
    }
}