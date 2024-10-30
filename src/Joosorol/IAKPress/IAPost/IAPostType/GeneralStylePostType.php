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
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\BFMediaFileType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Choice\ChoiceLayoutType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderBaseType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderStepType;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;

class GeneralStylePostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_GENERAL_STYLE_POST_TYPE;
    CONST NAME = Constants::IA_GENERAL_STYLE_POST_TYPE;

    const OPTION_NAME_PREFIX = 'p';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_TYPE); 

        $this->addField(
            new ChoiceLayoutType(
                PostConfig::POST_CONFIG_LAYOUT,
                [
                    Option::REQUIRED => false
                ],
                false
            )
        );


        $this->addField(
            new BFMediaFileType(
                self::buildOptionName(Option::POST_CONFIG_BG_IMG),
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                    Option::LABEL => FieldLabels::translate(Option::POST_CONFIG_BG_IMG)
                ],
                false
            )
        );

        $this->addField(
            new SliderStepType(
                self::buildOptionName(Option::POST_CONFIG_BG_OPACITY),
                [
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MAX => 1,
                    Option::VALUE => 0.7,
                    Option::RANGE_STEP => 0.1,
                    Option::LABEL => FieldLabels::translate(Option::POST_CONFIG_BG_OPACITY),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );

        
        $this->addField(
            new SliderStepType(
                self::buildOptionName(Option::POST_CONFIG_BG_MIN_HEIGHT),
                [
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MAX => 1200,
                    Option::VALUE => 700,
                    Option::RANGE_STEP => 5,
                    Option::LABEL => FieldLabels::translate(Option::POST_CONFIG_BG_MIN_HEIGHT),
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                ],
                false
            )
        );
    }

    public function getLabel() {
        return FieldLabels::translate(Option::GENERAL_STYLE);
    }

    public static function buildOptionName($name) {
        return sprintf("%s_%s", self::OPTION_NAME_PREFIX, $name);
    }
}