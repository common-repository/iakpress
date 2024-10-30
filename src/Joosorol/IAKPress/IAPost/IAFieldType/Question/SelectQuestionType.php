<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Question;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BasicFieldTypeBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\ChoiceListProps;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class SelectQuestionType extends BasicFieldTypeBase
{
    const TYPE = FieldRenderType::SELECT_QUESTION_TYPE;
    const RENDER_TYPE = FieldRenderType::QUESTION_RENDER_TYPE;
    const ICON = 'fa fa-question';

    public function __construct($name = self::TYPE, array $attrs = array(), $setDefault = true)
    {
        parent::__construct($name, self::TYPE, $attrs, false);

        if ($setDefault) {
            $option = Option::createOption([
                Option::FIELD_TYPE => FieldRenderType::OPTION_SUB_OPTIONS_TYPE,
                Option::NAME => Option::FIELD_TYPE,
                Option::REQUIRED => true,
                Option::RENDER_TYPE => FieldRenderType::SELECT_RENDER_TYPE,
                Option::DEFAULT_VALUE => SingleChoiceQuestion::TYPE,
                Option::FIELD_SECTION_ID => Option::FIELD_SECTION_GENERAL
            ]);

            $option->addSubOption(new SingleChoiceQuestion(SingleChoiceQuestion::TYPE, array(), false));
            $option->addSubOption(new MultiChoiceQuestion(MultiChoiceQuestion::TYPE, array(), false));

            $this->addOption($option);

            ChoiceListProps::add($this);


            parent::setDefaultOptions();
        }
    }

    public function getRenderType(): string
    {
        return self::RENDER_TYPE;
    }

    public static function addTypes(array &$fieldTypes, array &$blockTypes) {
        $fieldTypes[SelectQuestionType::TYPE] = (new SelectQuestionType())->toArray();
        $fieldTypes[SingleChoiceQuestion::TYPE] = (new SingleChoiceQuestion())->toArray();
        $fieldTypes[MultiChoiceQuestion::TYPE] = (new MultiChoiceQuestion())->toArray();
    }
}
