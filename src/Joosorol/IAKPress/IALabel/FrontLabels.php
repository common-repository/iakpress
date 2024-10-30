<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace  App\Joosorol\IAKPress\IALabel;

use App\Joosorol\WP\WPFrontLabels;

/**
 * class FrontLabels
 */
class FrontLabels
{
    /**
     * @var FrontLabels The single instance of the class
     */
    private static $sInstance = null;


    private Labels $_impl;

    /**
     * Constructor.
     */
    private function __construct()
    {
        if (defined('IAK_SYMFONY')) {
            $this->_impl = new SymfFrontLabels();
        } else {
            $this->_impl = new WPFrontLabels();
        }
    }

    /**
     * Main FrontLabels Instance
     *
     * Ensures only one instance of FrontLabels is loaded or can be loaded.
     *
     * @static
     * @return FrontLabels - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function getLabels(): array
    {
        return $this->_impl->getLabels();
    }

    public function getLabelByKey(string $key, string $defaultValue = null) : string {
        return $this->_impl->getLabelByKey($key, $defaultValue);
    }

    public static function translate(string $key, string $defaultValue = null) {
        return self::getInstance()->getLabelByKey($key, $defaultValue);
    }
}
