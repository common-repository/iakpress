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

interface GenericSessionModelInterface extends ContentModel
{
    public function getEntryByUsername(int $formConfigId, int $submitBtnType, string $username) : array;

    public function getEntryByEmail(int $formConfigId, int $submitBtnType, string $username) : array;

    public function addOrUpdateSession(int $formConfigId, array $requestData)  : array;

    public function resetPassword(int $formConfigId, array $requestData)  : array;
}