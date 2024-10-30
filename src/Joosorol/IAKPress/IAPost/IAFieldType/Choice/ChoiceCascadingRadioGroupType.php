<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Choice;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class ChoiceCascadingRadioGroupType extends ChoiceBase
{
    const TYPE = FieldRenderType::CHOICE_CASCADING_RADIO_GROUP_TYPE;
    const RENDER_TYPE = FieldRenderType::CHOICE_SELECT_RENDER_TYPE;
    const LABEL = 'Cascading Single-select List';

    public function __construct($name = self::TYPE, array $attrs = array())
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
