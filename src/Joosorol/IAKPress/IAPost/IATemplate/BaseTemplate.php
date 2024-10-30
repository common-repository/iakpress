<?php

/*
 * This file is part of iakpress-api package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

abstract class BaseTemplate  {
    const MIN_LENGTH = 2;

    
    /**
     * @var string
     */
    private $type;


    /**
     * Constructor
     * @param string $name
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    abstract public function getName();
    abstract public function getTitle();
    abstract public function getHelp();
    abstract public function getReadMoreUrl();
    abstract public function getReadMore();
    abstract public function getTextLines() : array;
    abstract public function getIcon();

    public function getSupports(): array
    {
        return array('title');
    }

    public static function getMainSectionFieldConfig(int $decoratorType = 0, $label = 'General', $fieldType = FieldRenderType::CONTAINER_BASIC_SECTION_TYPE) : array {
        return  [
            Option::NAME => Option::MAIN_SECTION,
            Option::LABEL => $label,
            Option::FIELD_TYPE => $fieldType,
            Option::DECORATOR_TYPE => $decoratorType
        ];
    }

    public function getDefaultFields(): array
    {
        return  [
        ];
    }

    public function toArray()
    {
        return [
            Option::TYPE => $this->type,
            Option::ID => $this->type,
            Option::NAME => $this->getName(),
            Option::TITLE => $this->getTitle(),
            Option::HELP => $this->getHelp(),
            Option::READ_MORE_URL => $this->getReadMoreUrl(),
            Option::READ_MORE => $this->getReadMore(),
            Option::TEXT_LINES => $this->getTextLines(),
            Option::ICON => $this->getIcon()
        ];
    }
}
