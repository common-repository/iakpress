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

interface PostConfigModelInterface extends ContentModel
{
    public function publish($id, array $requestData);

    public function unpublish($id, array $requestData);

    public function updatePostConfig(array &$requestData, array &$formDesc, array $entryId2InternalIdMap);

    public function fetchSingle($entryId, $entryId2InternalIdMap = array());
}