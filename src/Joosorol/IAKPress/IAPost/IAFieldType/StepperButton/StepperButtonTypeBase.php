<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\StepperButton;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\GeneralLayoutProps;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\RowLayoutProps;

abstract class StepperButtonTypeBase extends AbstractFieldType
{
    public function __construct($name, $type, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, $type, $attrs);

        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);

        RowLayoutProps::add($this);

        GeneralLayoutProps::add($this);
    }
}
