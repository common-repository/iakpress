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


class OrderModel extends GenericEntryModel
{
    /**
     * @var OrderModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * OrderModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main OrderModel Instance
     *
     * Ensures only one instance of OrderModel is loaded or can be loaded.
     *
     * @static
     * @return OrderModel - Main instance
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
        return Constants::IA_ORDER_POST_TYPE;
    }
}