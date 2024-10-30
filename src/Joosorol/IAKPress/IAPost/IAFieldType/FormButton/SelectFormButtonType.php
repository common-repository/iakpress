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

class SelectFormButtonType extends FormBaseButtonType
{
    const TYPE = FieldRenderType::SELECT_FORM_BTN_TYPE;
    const RENDER_TYPE = FieldRenderType::BF_BUTTON_RENDER_TYPE;
    const FIELD_TYPE = Option::FIELD_TYPE;
    const LABEL = 'Button Type';
    const ICON = 'fa fa-text-width';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => self::FIELD_TYPE,
                Option::LABEL => self::LABEL,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => FormSubmitButtonType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new FormSubmitButtonType(FormSubmitButtonType::TYPE, array(), false));
            $option->addSubOption(new FormSignUpButtonType(FormSignUpButtonType::TYPE, array(), false));
            $option->addSubOption(new FormLogInButtonType(FormLogInButtonType::TYPE, array(), false));
            $option->addSubOption(new FormResetPasswodButtonType(FormResetPasswodButtonType::TYPE, array(), false));

            $this->addOption($option);

            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    
    public function getImg()
    {
        return 'btn.svg';
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectFormButtonType::TYPE] = (new SelectFormButtonType())->toArray();

        $fieldTypes[FormSubmitButtonType::TYPE] = (new FormSubmitButtonType())->toArray();
        $fieldTypes[FormPreviousButtonType::TYPE] = (new FormPreviousButtonType())->toArray();
        $fieldTypes[FormNextButtonType::TYPE] = (new FormNextButtonType())->toArray();
        $fieldTypes[FormSignUpButtonType::TYPE] = (new FormSignUpButtonType())->toArray();
        $fieldTypes[FormLogInButtonType::TYPE] = (new FormLogInButtonType())->toArray();
        $fieldTypes[FormResetPasswodButtonType::TYPE] = (new FormResetPasswodButtonType())->toArray();
    }
}
