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
use App\Joosorol\IAKPress\IAPost\AbstractPostType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFDimensions;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFWeight;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;

class ProductVariantPostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_PRODUCT_VARIANT_POST_TYPE;
    CONST POST_CONFIG_TYPE = Constants::IA_PRODUCT_VARIANT_POST_TYPE;
    CONST NAME = Constants::IA_PRODUCT_VARIANT_POST_TYPE;

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
            Option::createOption([
                Option::NAME => Option::GROUP_ID,
                Option::LABEL => FieldLabels::translate(Option::GROUP_ID),
                Option::REQUIRED => true,
                Option::MODEL_ID => 0,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_SINGLE_SELECT_TYPE,
                Option::RENDER_TYPE => FieldRenderType::SELECT_CHOICE_TYPE,
            ])
        );

        $this->addField(
            Option::createOption([
                Option::NAME => Option::OPTION_ID,
                Option::PARENT_FIELD => Option::GROUP_ID,
                Option::LABEL => FieldLabels::translate(Option::OPTION_ID),
                Option::REQUIRED => true,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_CASCADING_SINGLE_SELECT_TYPE,
                Option::RENDER_TYPE => FieldRenderType::SELECT_CHOICE_TYPE
            ])
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
    }

    public function getLabel() {
        return 'Product Variant';
    }
}