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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

abstract class PTApiKeysConfig extends BaseTemplate
{
    const TITLE_FIELD = Option::TITLE;
    const TITLE_FIELD_LABEL = 'Label';

    const DESC_FIELD = Option::DESC;
    const DESC_FIELD_LABEL = 'Description';

    
    const PARAMS = 'params';
    const PARAMS_LABEL = 'Parameters';

    const MIN_LENGTH = 2;

    public function getSupports(): array
    {
        return array('title');
    }

    public function getEntryTitleLabel()
    {
        return PTApiKeysConfig::TITLE_FIELD_LABEL;
    }

    public function getEntryContentLabel()
    {
        return PTApiKeysConfig::DESC_FIELD_LABEL;
    }

    public abstract function doGetConfig(): ?ApiConfigBase;

    public final function getConfig(): array {
        $res = [];

        $res[] = ($this->doGetConfig())->toArray();

        return $res;
    }

    public function getIcon() {
        return 'track.png';
    }
}
