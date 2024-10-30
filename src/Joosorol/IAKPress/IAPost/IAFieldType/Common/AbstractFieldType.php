<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;

use App\Joosorol\IAKPress\IALabel\FieldLabels;

abstract class AbstractFieldType extends BaseOption
{
    const BF_CHECKBOX_TYPE = FieldRenderType::BF_CHECKBOX_TYPE;
    const BF_COLOR_TYPE = FieldRenderType::BF_COLOR_TYPE;
    const BF_EMAIL_TYPE = FieldRenderType::BF_EMAIL_TYPE;
    const BF_PASSWORD_TYPE = FieldRenderType::BF_PASSWORD_TYPE;
    const BF_TEL_TYPE = FieldRenderType::BF_TEL_TYPE;
    const BF_TEXT_TYPE = FieldRenderType::BF_TEXT_TYPE;
    const BF_TEXTAREA_TYPE = FieldRenderType::BF_TEXTAREA_TYPE;
    const SELECT_BF_TYPE = FieldRenderType::SELECT_BF_TYPE;
    const SELECT_SLIDER_TYPE = FieldRenderType::SELECT_SLIDER_TYPE;
    const SLIDER_RANGE_TYPE = FieldRenderType::SLIDER_RANGE_TYPE;
    const SLIDER_STEP_TYPE = FieldRenderType::SLIDER_STEP_TYPE;
    const SLIDER_FIXED_MIN_TYPE = FieldRenderType::SLIDER_FIXED_MIN_TYPE;
    const SLIDER_FIXED_MAX_TYPE = FieldRenderType::SLIDER_FIXED_MAX_TYPE;
    const SLIDER_MIN_DEFAULT = Option::RANGE_MIN;
    const SLIDER_MAX_DEFAULT = Option::RANGE_MAX;
    const LABEL_TYPE = 'iak_label';
    const CONFIG_TYPE = 'iak_config';


    const BF_CHECKBOX_RENDER_TYPE = FieldRenderType::BF_CHECKBOX_RENDER_TYPE;
    const BF_COLOR_RENDER_TYPE = FieldRenderType::BF_COLOR_RENDER_TYPE;
    const BF_DATE_RENDER_TYPE = FieldRenderType::BF_DATE_RENDER_TYPE;
    const BF_EMAIL_RENDER_TYPE = FieldRenderType::BF_EMAIL_RENDER_TYPE;
    const BF_NUMBER_RENDER_TYPE = FieldRenderType::BF_NUMBER_RENDER_TYPE;
    const BF_PASSWORD_RENDER_TYPE = FieldRenderType::BF_PASSWORD_RENDER_TYPE;
    const BF_RADIO_RENDER_TYPE = FieldRenderType::BF_RADIO_RENDER_TYPE;
    const BF_TEL_RENDER_TYPE = FieldRenderType::BF_TEL_RENDER_TYPE;
    const BF_TEXTAREA_RENDER_TYPE = FieldRenderType::BF_TEXTAREA_RENDER_TYPE;
    const BF_TEXT_RENDER_TYPE = FieldRenderType::BF_TEXT_RENDER_TYPE;
    const SELECT_RENDER_TYPE = FieldRenderType::SELECT_RENDER_TYPE;
    const LABEL_RENDER_TYPE = FieldRenderType::LABEL_RENDER_TYPE;
    const POST_CONFIG_RENDER_TYPE = FieldRenderType::POST_CONFIG_RENDER_TYPE;
    const SLIDER_RENDER_TYPE = FieldRenderType::SLIDER_RENDER_TYPE;
    const BF_HIDDEN_RENDER_TYPE = FieldRenderType::BF_HIDDEN_RENDER_TYPE;
    const CONFIG_RENDER_TYPE = FieldRenderType::CONFIG_RENDER_TYPE;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $attrs;

    /**
     * Constructor
     * @param string $name
     */
    public function __construct($name, $type, array $attrs = array())
    {
        parent::__construct();

        $this->name = $name;
        $this->type = $type;
        $this->options = array();
        $this->attrs = $attrs;
        
        if (!isset($this->attrs[Option::FIELD_SECTION_ID])) {
            $this->attrs[Option::FIELD_SECTION_ID] = Option::FIELD_SECTION_GENERAL;
        }

        if (!isset($attrs[Option::LABEL])) {
            $this->attrs[Option::LABEL] = FieldLabels::translate($this->name);
        }
    }

    protected function setDefaultOptions($defaultSection = Option::FIELD_SECTION_GENERAL)
    {
        $this->addOption(
            Option::createOption([
                Option::NAME => Option::ID,
                Option::HIDE => true,
                Option::RENDER_TYPE => AbstractFieldType::BF_HIDDEN_RENDER_TYPE,
                Option::VALUE => 0,
                Option::FIELD_SECTION_ID => $defaultSection,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::RENDER_TYPE,
                Option::HIDE => true,
                Option::RENDER_TYPE => AbstractFieldType::BF_HIDDEN_RENDER_TYPE,
                Option::VALUE => '',
                Option::FIELD_SECTION_ID => $defaultSection,
            ])
        );

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::PARENT_ID,
                Option::HIDE => true,
                Option::RENDER_TYPE => AbstractFieldType::BF_HIDDEN_RENDER_TYPE,
                Option::VALUE => 0,
                Option::FIELD_SECTION_ID => $defaultSection,
            ])
        );

        $this->addOption(Option::createOption([
            Option::NAME => Option::LABEL,
            Option::REQUIRED => true,
            Option::HIDE => false,
            Option::MIN_LENGTH => 2,
            Option::MAX_LENGTH => 225,
            Option::RENDER_TYPE => self::BF_TEXT_RENDER_TYPE,
            Option::FIELD_SECTION_ID => $defaultSection,
        ]));

        $this->addOption(
            Option::createOption([
                Option::NAME => Option::NAME,
                Option::REQUIRED => false,
                Option::HIDE => false,
                Option::RENDER_TYPE => AbstractFieldType::BF_TEXT_RENDER_TYPE,
                Option::VALUE => '',
                Option::MIN_LENGTH => 2,
                Option::MAX_LENGTH => 225,
                Option::FIELD_SECTION_ID => $defaultSection,
            ])
        );

       
        return $this;
    }

    public function setAttr($attrName, $attrValue)
    {
        $this->attrs[$attrName] = $attrValue;
    }

    public function addOption(BaseOption $option, $setDefault = true)
    {
        $this->options[$option->getName()] = $option->toArray();
        return $this;
    }

    abstract public function getRenderType(): string;

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getImg()
    {
        return '';
    }

    public function getLabel() {
        return $this->attrs[Option::LABEL] ?? '';
    }

    public function getValue() {
        return $this->attrs[Option::VALUE] ?? '';
    }

    public function toArray()
    {
        return array_merge(
            [
                Option::NAME => $this->getName(),
                Option::RENDER_TYPE => $this->getRenderType(),
                Option::FIELD_TYPE => $this->getType(),
                Option::IMG => $this->getImg(),
                Option::OPTIONS => $this->getOptions(),
            ],
            $this->attrs
        );
    }
}
