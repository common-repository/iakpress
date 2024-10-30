<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\ContainerField;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class ContainerBasicSectionType extends ContainerSectionBase
{
    const TYPE = FieldRenderType::CONTAINER_BASIC_SECTION_TYPE;
    const RENDER_TYPE = FieldRenderType::CONTAINER_RENDER_TYPE;
    const LABEL = 'Basic Section';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct(
            $name,
            self::TYPE,
            array_merge(
                [
                    Option::LABEL => self::LABEL
                ],
                $attrs),
            $setDefault);

        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
