<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;


class SimpleSubOption extends BaseOption {
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $fpath;

    /**
     * Constructor
     */
    public function __construct($value, $label, $fpath = '')
    {
        $this->value = $value;
        $this->label = $label;
        $this->fpath = $fpath;
    }

    public function getName() {
        return $this->value;
    }

    public function getValue() {
        return $this->value;
    }

    public function getLabel() {
        return $this->label;
    }

    public function toArray() {
        $res = [
            Option::LABEL => $this->getLabel(),
            Option::VALUE => $this->getValue(),
        ];

        if (!empty($this->fpath)) {
            $res[Option::FILE_PATH] = $this->fpath;
        }

        return $res;
    }
}