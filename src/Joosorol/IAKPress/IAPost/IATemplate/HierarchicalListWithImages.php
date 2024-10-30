<?php

/*
 * This file is part of iakpress package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class HierarchicalListWithImages extends SimpleListWithImages
{
    const TYPE_VALUE = TemplateTypes::FT_MODEL_HIERARCHICAL_LIST_WITH_IMAGES;
    const NAME = 'hierarchical-list-with-images';
    const TITLE_TEXT = 'Hierarchical List with images';
    const HELP_TEXT = '';

    const READ_MORE_TEXT = '';

    const FILE_PATH = Option::FILE_PATH;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE);
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getTitle()
    {
        return self::TITLE_TEXT;
    }

    public function getHelp()
    {
        return self::HELP_TEXT;
    }

    public function getTextLines(): array
    {
        return [];
    }

    public function getReadMoreUrl()
    {
        return '';
    }

    public function getReadMore()
    {
        return self::READ_MORE_TEXT;
    }

    public function getIcon() {
        return '';
    }
}
