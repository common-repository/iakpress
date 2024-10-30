<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\AbstractFieldType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class BFPasswordType extends BasicFieldTypeBase
{
    const TYPE = AbstractFieldType::BF_PASSWORD_TYPE;
    const RENDER_TYPE = AbstractFieldType::BF_PASSWORD_RENDER_TYPE;
    const LABEL = 'Password';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct(
            $name,
            self::TYPE,
            array_merge(
                [
                    Option::LABEL => self::LABEL,
                    Option::PATTERN => Constants::PASSWORD_REGEX,
                    Option::FORMAT_MSG => FieldLabels::translate(Option::PASSWORD_ERROR_MSG)
                ],
                $attrs),
            false);

        if ($setDefault) {
            ValidationProps::add($this);
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
