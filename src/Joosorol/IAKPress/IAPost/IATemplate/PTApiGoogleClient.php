<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\IAFieldType\ApiConfig\ApiConfigBase;
use App\Joosorol\IAKPress\IAPost\IAFieldType\ApiConfig\GoogleClientConfigType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class PTApiGoogleClient extends PTApiKeysConfig {
    const TYPE_VALUE = TemplateTypes::FT_GOOGLE_CLIENT;
    const NAME = 'google-client';
    const TITLE_TEXT = 'Google Client';
    const HELP_TEXT = 'Google Client Config';
    
    const READ_MORE_TEXT = 'Learn more';

    const PARAMS_LABEL = 'Google Client Parameters';

    /**
     * Constructor
     * @param string $name
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_VALUE); 
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

    public function doGetConfig(): ?ApiConfigBase
    {
        return new GoogleClientConfigType(
                self::PARAMS, 
                [
                    Option::LABEL => self::PARAMS_LABEL,
                    Option::HIDE_LABEL => true
                ]);
    }

    public function getIcon() {
        return 'api.png';
    }
}
