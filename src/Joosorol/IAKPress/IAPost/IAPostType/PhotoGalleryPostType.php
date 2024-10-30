<?php

/*
 * This file is part of iakboot-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFIntegerType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Media\MediaUploadImageType;
use App\Joosorol\IAKPress\IAPost\Constants;

class PhotoGalleryPostType extends SubPostType {
    const POST_TYPE = Constants::IA_PHOTO_GALLERY_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_PHOTO_GALLERY_POST_TYPE;
    CONST NAME = Constants::IA_PHOTO_GALLERY_POST_TYPE;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_CONFIG_TYPE);

        $this->addField(
            new MediaUploadImageType(
                Option::FILE_PATH,
                [
                    Option::LABEL => FieldLabels::translate(Option::IMAGE_PATH),
                    Option::REQUIRED => true,
                ],
                false
            )
        );

        $this->addField(
            new BFIntegerType(
                Option::MENU_ORDER,
                [
                    Option::LABEL => FieldLabels::translate(Option::MENU_ORDER),
                ],
                false
            )
        );
    }

    public function getLabel() {
        return 'Photo gallery';
    }
}