<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Media;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use  App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFMediaFileType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFUrlType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\GeneralLayoutProps;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\InputSettingsProps;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\RowLayoutProps;

abstract class MediaTypeBase extends AbstractFieldType
{
    const FILE_PATH = Option::FILE_PATH;
    const FILE_PATH_LABEL = 'Source URL';
    const THUMB_PATH_LABEL = 'Thumb URL';


    const CONTENT = Option::CONTENT;

    public function __construct($name, $type, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, $type, $attrs);
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        parent::setDefaultOptions($defaultSection);

        GeneralLayoutProps::add($this);

        InputSettingsProps::add($this);

        RowLayoutProps::add($this);
    }
}
