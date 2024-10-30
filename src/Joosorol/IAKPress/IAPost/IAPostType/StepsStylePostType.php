<?php

/*
 * This file is part of iakpress package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAPostType;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\AbstractPostType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Checkbox\BasicCheckboxType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;

class StepsStylePostType extends AbstractPostType {
    const POST_TYPE = Constants::IA_STEPS_STYLE_POST_TYPE;
    CONST NAME = Constants::IA_STEPS_STYLE_POST_TYPE;

    static function getCssClasses() {
        static $cssClasses;

        if (!$cssClasses) {
            $cssClasses = [
                Option::STEP_PREV_BTN_LBL => [ FieldLabels::translate(Option::STEP_PREV_BTN_LBL), '' ],
                Option::STEP_NEXT_BTN_LBL => [ FieldLabels::translate(Option::STEP_NEXT_BTN_LBL), '' ],
        
                Option::STEP_BTN_C_CLS => [ FieldLabels::translate(Option::STEP_BTN_C_CLS),  '.iak-step-btn-c' ],
                Option::STEP_BTN_R_CLS => [ FieldLabels::translate(Option::STEP_BTN_R_CLS), '.iak-step-btn-r' ],
                Option::STEP_BTN_CLS => [ FieldLabels::translate(Option::STEP_BTN_CLS),  '.iak-step-btn' ],
                Option::STEP_PREVBTN_CLS => [ FieldLabels::translate(Option::STEP_PREVBTN_CLS), '.iak-step-prevbtn' ],
                Option::STEP_NEXTBTN_CLS => [ FieldLabels::translate( Option::STEP_NEXTBTN_CLS), '.iak-step-nextbtn' ],
        
                Option::STEP_IND_C_CLS => [ FieldLabels::translate(Option::STEP_IND_C_CLS), '.iak-step-ind-c' ],
                Option::STEP_IND_R_CLS => [ FieldLabels::translate(Option::STEP_IND_R_CLS),'.iak-step-ind-r' ],
                Option::STEP_IND_CLS => [ FieldLabels::translate( Option::STEP_IND_CLS), '.iak-step-ind' ],
                Option::STEP_IND_A_CLS => [ FieldLabels::translate(Option::STEP_IND_A_CLS), '.iak-step-ind-a' ]
            ];
        }

        return $cssClasses;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::POST_TYPE); 
        
       
        $this->addField(
            new BasicCheckboxType(
                Option::STEP_FORM_ENABLED,
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                    Option::LABEL => FieldLabels::translate(Option::STEP_FORM_ENABLED)
                ],
                false
            )
        );

        $this->addField(
            new BasicCheckboxType(
                Option::HIDE_PREV_BTN,
                [
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL,
                    Option::LABEL => FieldLabels::translate(Option::HIDE_PREV_BTN)
                ],
                false
            )
        );

        foreach(self::getCssClasses() as $fieldName => $val) {
            $this->addField(
                Option::createOption([
                    Option::NAME =>  $fieldName,
                    Option::FIELD_TYPE => FieldRenderType::BF_TEXT_TYPE,
                    Option::TYPE => FieldRenderType::SELECT_BF_TYPE,
                    Option::RENDER_TYPE => FieldRenderType::BF_TEXT_RENDER_TYPE,
                    Option::LABEL => $val[0],
                    Option::PLACEHOLDER => $val[1],
                    Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
                ])
            );
        }
    }

    public function getLabel() {
        return FieldLabels::translate(Option::STEPS_STYLE);
    }
}