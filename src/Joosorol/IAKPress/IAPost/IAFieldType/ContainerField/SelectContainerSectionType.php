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

class SelectContainerSectionType extends ContainerSectionBase
{
    const TYPE = FieldRenderType::SELECT_CONTAINER_TYPE;
    const RENDER_TYPE = FieldRenderType::CONTAINER_RENDER_TYPE;
    const ICON = 'fas fa-columns';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                Option::DEFAULT_VALUE => ContainerBasicSectionType::TYPE
            ]);

            $option->addSubOption(new ContainerBasicSectionType (ContainerBasicSectionType::TYPE, array(), false));
            $option->addSubOption(new ContainerSignUpSectionType (ContainerSignUpSectionType::TYPE, array(), false));

            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public function getImg()
    {
        return 'sections.svg';
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectContainerSectionType::TYPE] = (new SelectContainerSectionType())->toArray();
        $fieldTypes[ContainerBasicSectionType::TYPE] = (new ContainerBasicSectionType())->toArray();
        $fieldTypes[ContainerSignUpSectionType::TYPE] = (new ContainerSignUpSectionType())->toArray();
    }
}
