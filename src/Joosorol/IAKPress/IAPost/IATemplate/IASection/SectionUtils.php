<?php

/*
 * This file is part of iakpress-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate\IASection;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SectionUtils {
    const TITLE_FIELD = Option::TITLE;
    const DESC_FIELD = Option::DESC;
    const SLUG_FIELD = Option::SLUG;
    const EMAIL_FIELD = Option::EMAIL;

	public static function getDefaultFields($sectionName, $fieldType) : array {
        $modelType = intval($fieldType);

        switch ($modelType) {
            case  FieldRenderType::CONTAINER_SIGN_UP_SECTION_TYPE:
                return SignUpSection::getConfig($sectionName);

            default:
                break;
        }

        return [];
    }
}
