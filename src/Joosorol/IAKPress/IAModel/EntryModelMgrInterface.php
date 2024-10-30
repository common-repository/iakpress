<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAModel;

abstract class EntryModelMgrInterface
{
    
    abstract public function getModelByPostType($postType, $formConfigId = 0, $templateId = 0) : ?ContentModel;
}
