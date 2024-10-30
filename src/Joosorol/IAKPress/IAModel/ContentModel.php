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

interface ContentModel
{
  /**
   * Get the postType
   */
  public function getPostType($formConfigId = 0, $templateId = 0);

  public function fromDb($post, $formConfigId = 0, $modelId = 0): array;

  public function toDb(array $values, $formConfigId = 0): PostData;

  public function doEdit($formConfigId, $entryId, array $requestData);

  
  /**
   * Delete entry
   * @param integer $formConfigId
   * @param integer $entryId
   * @return
   */
  public function delete($formConfigId, $entryId, $queryVars = array());

  /**
   * Do Delete entry
   * @param integer $entryId
   * @return
   */
  public function doDelete($formConfigId, $entryId, $queryVars = array());

  /**
   * Do Delete entries
   * @param array $ids
   * @return
   */
  public function doMassDelete($formConfigId, array $ids, array $queryVars = array());


  public function doFetchList($formConfigId, array $args = array(), $entry = array(), $modelId = 0);


  public function search($formConfigId, array $args = array());

  public function getByParentIdAndId($formConfigId, $id);

  public function getById($id, $formConfigId = 0);
  
  public function init();
  
  public function edit($formConfigId, $entryId, array $requestData);

  public function doFastEdit($formConfigId, $entryId, array $requestData, array &$errors);

  public function fetchList($formConfigId, $entry = array(), $queryVars = array());

  public function getByPostypeAndId($postType, $id, $formConfigId = 0, $modelId = 0);

  public function validateForm(int $formConfigId, int $entryId, array $requestData, array &$errors);
}
