<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class PTPhotoGallery extends BaseTemplate {
    const TYPE_VALUE = TemplateTypes::FT_PHOTO_GALLERY;
    const NAME = 'photogallery';
    const TITLE_TEXT = 'Photo Gallery';
    const HELP_TEXT = 'Build beautiful mobile-friendly galleries in a few minutes.';
    const READ_MORE_TEXT = 'Learn more';

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
            self::getMainSectionFieldConfig(FieldRenderType::DECORATOR_IMAGE_ITEM_TYPE),
            [
                Option::NAME => Option::IMAGE_LIST,
                Option::LABEL => FieldLabels::translate(Option::IMAGE_LIST),
                Option::REQUIRED => false,
                Option::FIELD_TYPE => FieldRenderType::CHOICE_IMAGE_LIST,
                Option::SECTION_NAME => Option::MAIN_SECTION,
                Option::DECORATOR_TYPE => FieldRenderType::DECORATOR_IMAGE_ITEM_TYPE
            ]
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

    public function getReadMoreUrl() {
        return '';
    }

    public function getReadMore() {
        return self::READ_MORE_TEXT;
    }

    public function getTextLines() : array {
        return [];
    }

    public function getIcon() {
        return 'ico_image.png';
    }
}