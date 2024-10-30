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
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFNumericType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFTextType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Color\ColorPaletteType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Media\MediaUploadImageType;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFWeight;

class AttachmentPostType extends SubPostType {
    const POST_TYPE = Constants::IA_ATTACHMENT_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_ATTACHMENT_POST_TYPE;
    CONST NAME = Constants::IA_ATTACHMENT_POST_TYPE;

    const COLOR_FIELD = 'color';
    const COLOR_FIELD_LABEL = 'Color';


    const OPTION_COLOR_TYPE = 'color';
    const OPTION_CUSTOM_TYPE = 'custom';


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_CONFIG_TYPE); 

        $this->addField(
            new BFTextType(
                Option::OPTION_LONG_NAME,
                [
                    Option::LABEL => FieldLabels::translate(Option::OPTION_LONG_NAME),
                    Option::REQUIRED => false
                ],
                false
            )
        );

        $this->addField(
            new BFNumericType(
                Option::REGULAR_PRODUCT_PRICE,
                [
                    Option::LABEL => FieldLabels::translate(Option::REGULAR_PRODUCT_PRICE),
                ],
                false
            )
        );


        $this->addField(
            new MediaUploadImageType(
                Option::FILE_PATH,
                [
                    Option::LABEL => FieldLabels::translate(Option::FEATURED_IMAGE),
                ],
                false
            )
        );

        $this->addField(
            new ColorPaletteType(
                self::COLOR_FIELD,
                [
                    Option::LABEL => FieldLabels::translate(self::COLOR_FIELD,  self::COLOR_FIELD_LABEL),
                ],
                false
            )
        );

        $this->addField(
            new BFWeight(
                Option::WEIGHT,
                [
                    Option::LABEL => FieldLabels::translate(Option::WEIGHT,  Option::WEIGHT_LABEL),
                ],
                false
            )
        );
    }

    public function getLabel() {
        return 'Attachment';
    }
}