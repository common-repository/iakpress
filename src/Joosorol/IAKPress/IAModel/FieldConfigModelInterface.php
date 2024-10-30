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

interface FieldConfigModelInterface extends ContentModel
{
    public function saveFields(array $requestData, $formConfigId, array &$entryId2InternalIdMap);

    public function deleteFields($formConfigId);

    public function getDatalist(array $fields, array $fieldConfig): array;
}