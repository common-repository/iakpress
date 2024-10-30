<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;

/**
 * Marker class
 */
abstract class BaseOption {

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    abstract public function getName();

    abstract public function getLabel();

    abstract public function getValue();

    abstract public function toArray();
}