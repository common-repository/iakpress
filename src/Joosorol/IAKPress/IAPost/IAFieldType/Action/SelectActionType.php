<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Action;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SelectActionType extends ActionTypeBase
{
    const TYPE = FieldRenderType::SELECT_ACTION_TYPE;
    const RENDER_TYPE = FieldRenderType::ACTION_RENDER_TYPE;

    const DEFAULT_ICON = 'fas fa-paper-plane';
    const COMMENTS_ICON = 'fa fa-comments';
    const THANKYOU_ICON = 'fa fa-thumbs-up';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => ActionMailNotificationType::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new ActionMailNotificationType (ActionMailNotificationType::TYPE, array(), false));
            $option->addSubOption(new ActionThankYouScreenType (ActionThankYouScreenType::TYPE, array(), false));

            $option->addSubOption(new ActionEmailConfirmationType (ActionEmailConfirmationType::TYPE, array(), false));
            $option->addSubOption(new ActionForgotPasswordType (ActionForgotPasswordType::TYPE, array(), false));

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
        return 'notification.svg';
    }


    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectActionType::TYPE] = (new SelectActionType())->toArray();
        $fieldTypes[ActionMailNotificationType::TYPE] = (new ActionMailNotificationType())->toArray();
        $fieldTypes[ActionThankYouScreenType::TYPE] = (new ActionThankYouScreenType())->toArray();
        $fieldTypes[ActionEmailConfirmationType::TYPE] = (new ActionEmailConfirmationType())->toArray();
        $fieldTypes[ActionForgotPasswordType::TYPE] = (new ActionForgotPasswordType())->toArray();
    }
}
