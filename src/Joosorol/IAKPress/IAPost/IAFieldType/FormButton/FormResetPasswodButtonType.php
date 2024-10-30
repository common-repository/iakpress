<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\FormButton;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class FormResetPasswodButtonType extends FormBaseButtonType
{
    const TYPE = FieldRenderType::FORM_BTN_RESET_PASSWORD_TYPE;
    const RENDER_TYPE = FieldRenderType::BF_BUTTON_RENDER_TYPE;
    const LABEL = 'Reset Password';

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
            $setDefault);
        
        if ($setDefault) {
            $this->setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }
}
