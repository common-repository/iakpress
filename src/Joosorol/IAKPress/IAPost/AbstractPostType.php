<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\BaseOption;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

abstract class AbstractPostType
{
    const POST_CONFIG_TYPE = Option::POST_CONFIG_TYPE;
    const FIELDS = 'fields';

    CONST POST_CONFIG_TITLE = 'title';
    CONST POST_CONFIG_LAYOUT = Option::POST_CONFIG_LAYOUT;
    CONST POST_CONFIG_CONTENT = 'form_content';
    const LABEL = 'label';
    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $attrs;


    /**
     * Constructor
     * @param string $name
     */
    public function __construct($type, $attrs = array())
    {
        $this->type = $type;
        $this->fields = array();
        $this->attrs = $attrs;
    }

    public function addField(BaseOption $field)
    {
        $this->fields[$field->getName()] = $field->toArray();

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getLabel() {
        return '';
    }
    
    public function toArray()
    {
        return array_merge (
            [
                self::POST_CONFIG_TYPE => $this->getType(),
                self::LABEL => $this->getLabel(),
                self::FIELDS => $this->getFields()
            ],
            $this->attrs
        );
    }
}
