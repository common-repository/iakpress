<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;

class PTSignupForm extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_SIGN_UP_FORM;
    const NAME = 'signupform';
    const TITLE_TEXT = 'Sign-Up Form';
    const HELP_TEXT = 'Get More Leads and Sales with Sign-Up Forms.';
    
    const READ_MORE_TEXT = 'Learn more';

    const SIGN_UP_LABEL = 'Sign up';

    
    /**
     * Constructor
     * @param string $name
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE); 
    }

    public function getDefaultFields(): array
    {
        return  [
            self::getMainSectionFieldConfig(
                0,
                self::SIGN_UP_LABEL,
                FieldRenderType::CONTAINER_SIGN_UP_SECTION_TYPE
            )
        ];
    }


    public function getName() {
        return self::NAME;
    }
    
    public function getTitle() {
        return self::TITLE_TEXT;
    }
    
    public function getHelp() {
        return self::HELP_TEXT;
    }

    public function getTextLines() : array {
        return [];
    }

    public function getReadMoreUrl() {
        return '';
    }

    public function getReadMore() {
        return self::READ_MORE_TEXT;
    }

    public function getIcon() {
        return 'ico_create_quizz.png';
    }
}