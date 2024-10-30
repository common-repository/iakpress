<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAModel\Symf;


use App\Joosorol\IAKPress\IAModel\ContentModel;
use App\Joosorol\IAKPress\IAModel\EntryModelMgrInterface;


class SymfEntryModelMgr extends EntryModelMgrInterface
{
    public function getModelByPostType($postType, $formConfigId = 0, $templateId = 0) : ?ContentModel
    {
        return null;
    }
}
