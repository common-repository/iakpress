<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderBaseType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderFixedMinType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderRangeType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SliderStepType;

class ValidationProps
{
    const VALIDATION = 'validation';
    const VALIDATION_LABEL = 'Validation';

    const MIN_LEN_LABEL = 'char_count';

    private function __construct()
    {

    }

    public static function add(AbstractFieldType &$field)
    {

        $field->addOption(
            new SliderFixedMinType(
                Option::MIN_LENGTH,
                [
                    Option::LABEL =>  Option::MIN_LENGTH_LABEL,
                    Option::RANGE => SliderBaseType::RANGE_STEP,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MIN_DEFAULT => 0,
                    Option::RANGE_MAX => 999,
                    Option::RANGE_MAX_DEFAULT => 999,
                    Option::VALUE => 0,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );

        $field->addOption(
            new SliderFixedMinType(
                Option::MAX_LENGTH,
                [
                    Option::LABEL =>  Option::MAX_LENGTH_LABEL,
                    Option::RANGE => SliderBaseType::RANGE_MIN,
                    Option::RANGE_MIN => 0,
                    Option::RANGE_MIN_DEFAULT => 0,
                    Option::RANGE_MAX => 999,
                    Option::RANGE_MAX_DEFAULT => 999,
                    Option::VALUE => 0,
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_SETTINGS,
                ],
                false
            )
        );
    }
}
