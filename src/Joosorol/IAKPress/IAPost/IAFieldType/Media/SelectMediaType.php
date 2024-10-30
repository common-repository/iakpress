<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Media;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SelectMediaType extends MediaTypeBase
{
    const TYPE = FieldRenderType::SELECT_MEDIA_TYPE;
    const RENDER_TYPE = FieldRenderType::MEDIA_RENDER_TYPE;
    const DEFAULT_ICON = 'fas fa-photo-video';
    const LINK_ICON = 'fa fa-link';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            // add field_type option
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => MediaImageType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new MediaImageType (MediaImageType::TYPE, array(), false));
            $option->addSubOption(new MediaUploadImageType (MediaUploadImageType::TYPE, array(), false));
            $option->addSubOption(new MediaUploadFileType (MediaUploadFileType::TYPE, array(), false));

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
        return 'image.svg';
    }


    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectMediaType::TYPE] = (new SelectMediaType())->toArray();
        $fieldTypes[MediaImageType::TYPE] = (new MediaImageType())->toArray();
        $fieldTypes[MediaUploadImageType::TYPE] = (new MediaUploadImageType())->toArray();
        $fieldTypes[MediaUploadFileType::TYPE] = (new MediaUploadFileType())->toArray();
    }
}
