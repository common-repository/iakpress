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

class MediaUploadFileType extends MediaTypeBase
{
    const TYPE = FieldRenderType::MEDIA_UPLOAD_FILE_TYPE;
    const RENDER_TYPE = FieldRenderType::MEDIA_RENDER_TYPE;
    const LABEL = 'Upload File';

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
                false);
    }
    

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
