<?php
/*
* This file is part of the IAKPress package.
*
* (c) Joosorol 
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace App\Joosorol\WP\IAModel;

use Symfony\Component\Uid\Ulid;

use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\ContentModel;
use App\Joosorol\IAKPress\IAModel\EntryStatus;
use App\Joosorol\IAKPress\IAModel\PostData;
use  App\Joosorol\IAKPress\IALabel\AdminLabels;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\PostUtils;

abstract class WPContentModel implements ContentModel
{
  const ACTION = 'action';
  const FETCH_LIST_ACTION = 'fetch_list';
  const FETCH_SINGLE_ACTION = 'fetch_single';
  const CREATE_ACTION = 'create';
  const UPDATE_ACTION = 'update';

  protected final function getPostTitle(PostData $data)
  {
    $postType = $this->getPostType();

    if ($postType != Constants::IA_LINKED_PRODUCT_POST_TYPE) {
      $templateId = intval($data->getTemplateId());
      $isForm = TemplateTypes::isForm($templateId);

      if (
        !$isForm ||
        $templateId == TemplateTypes::FT_CONTACT_FORM
      ) {
        return wp_strip_all_tags($data->getPostTitle());
      }
    }

    if (intval($data->getId()) === 0) {
      return (new Ulid())->toBase32();
    }

    return null;
  }

  /**
   * Create content
   * @param PostData $data
   * @return WPContentModel WP_Post
   */
  public function doCreate($formConfigId, PostData $data, array &$errors)
  {
    // Create the Content post object

    $templateId = intval($data->getTemplateId());
    $isForm = TemplateTypes::isForm($templateId);

    $postTitle =  $this->getPostTitle($data);

    $post = array(
      'post_title'    =>  $postTitle,
      'post_content'  => $data->getPostContent(),
      'post_excerpt'  => $data->getPostExcerpt(),
      'menu_order'  => $data->getMenuOrder(),
      'post_status'   => $data->getPostStatus(),
      'post_author'   => $data->getPostAuthor(),
      'post_type'     => $data->getPostType()
    );

    if ($isForm) {
      $post['post_status'] = EntryStatus::STATUS_UNREAD;
    } else {
      $post['post_status'] = EntryStatus::STATUS_PUBLISH;
    }

    $post['post_parent'] = $data->getPostParent();

    if (!empty($data->getPostName())) {
      $post['post_name'] = $data->getPostName();
    }

    // Insert the post into the database
    $postId = wp_insert_post($post);
    return get_post($postId);
  }
  /**
   * Update content
   * @param int $formConfigId
   * @param PostData $data
   * @return WP_Post
   * @param $formConfigId
   */
  public function doUpdate($formConfigId, PostData $data, array &$errors)
  {
    // Update the post content
    $post = array(
      'ID'            => $data->getId(),
      'menu_order'  => $data->getMenuOrder()
    );

    $templateId = intval($data->getTemplateId());

    $postTitle =  $this->getPostTitle($data);

    if (!empty($postTitle)) {
      $post['post_title'] = $postTitle;
    }

    if (TemplateTypes::isCustomPostType($data->getTemplateId())) {
      $post['post_excerpt'] = $data->getPostExcerpt();
    }

    $post['post_content'] = $data->getPostContent();

    // Update the post into the database
    $this->updatePost($formConfigId, $post, $data->getMetaValues());

    return self::doFindById($data->getId());
  }

  public function updatePostMeta(int $postId, string $metaKey, $metaValue)
  {
    PostUtils::getInstance()->updatePostMeta($postId, $metaKey, $metaValue);
  }

  public function getPostMeta(int $postId, string $key = '', bool $single = false)
  {
    return PostUtils::getInstance()->getPostMeta($postId, $key, $single);
  }

  public function deletePostMeta(int $postId, string $key)
  {
    PostUtils::getInstance()->deletePostMeta($postId, $key);
  }

  public function deletePost($formConfigId, int $postId, bool $forceDelete = false, $queryVars = array())
  {
    PostUtils::getInstance()->deletePost($postId, $forceDelete);
  }

  public function updatePost($formConfigId, array $formData, array $queryVars = array())
  {
    PostUtils::getInstance()->updatePost($formData, $queryVars);
  }

  protected function doInsertPostMeta($values)
  {
    global $wpdb;
    $query = "INSERT INTO " . $wpdb->postmeta . "  (post_id, meta_key, meta_value) VALUES " . $values;
    $wpdb->query($query);
  }

  /**
   * Create/Update content
   * @param int $formConfigId
   * @param PostData $data
   * @return WP_Post
   */
  public function doCreateOrUpdate($formConfigId, PostData $data, array &$errors)
  {
    $id = intval($data->getId());

    if ($id == 0) {
      return $this->doCreate($formConfigId, $data, $errors);
    } else {
      return $this->doUpdate($formConfigId, $data, $errors);
    }
  }

  abstract function toDb(array $values, $formConfigId = 0): PostData;

  public function fetchSingle($entryId, $entryId2InternalIdMap = array())
  {
    return PostUtils::getInstance()->getPostById($entryId);
  }

  public static function doFindById($id)
  {
    return PostUtils::getInstance()->getPostById($id);
  }

  public function getById($id, $formConfigId = 0)
  {
    $entry = self::doFindById($id);

    if ($entry) {
      $theModelId = intval($this->getModelId($entry, $formConfigId, 0));

      return $this->fromDb($entry, $formConfigId, $theModelId);
    } else {
      return null;
    }
  }

  public function getContent($id)
  {
    $entry = self::doFindById($id);

    if ($entry) {
      return $entry->post_content;
    } else {
      return null;
    }
  }

  public function getByPostypeAndId($postType, $id, $formConfigId = 0, $modelId = 0)
  {
    $post = self::doFindById($id);
    if ($post) {
      if ($post->post_type == $postType) {
        $theModelId = intval($this->getModelId($post, $formConfigId, $modelId));
        return $this->fromDb($post, $formConfigId, $theModelId);
      }
    }

    return null;
  }

  public function getByParentIdAndId($formConfigId, $id)
  {
    $post = self::doFindById($id);
    if ($post) {
      if ($post->post_type == $this->getPostType($formConfigId)) {
        $theModelId = intval($this->getModelId($post, $formConfigId, 0));
        return $this->fromDb($post, $formConfigId, $theModelId);
      }
    }

    return null;
  }

  public function getIdByParentIdAndName($formConfigId, $name)
  {
    global $wpdb;

    $id = $wpdb->get_var(
      $wpdb->prepare(
        'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_name = %s and post_parent=%s',
        $name,
        $formConfigId
      )
    );

    if (empty($id)) {
      return 0;
    } else {
      return intval($id);
    }
  }

  public function init() {

  }
  
  public function edit($formConfigId, $entryId, array $requestData)
  {
      return $this->doEdit($formConfigId, $entryId, $requestData);
  }

  public function doFastEdit($formConfigId, $entryId, array $requestData, array &$errors) {
    return $this->doEdit($formConfigId, $entryId, $requestData);
  }

  /**
   * Delete entry
   * @param integer $formConfigId
   * @param integer $entryId
   * @return
   */
  public function delete($formConfigId, $entryId, $queryVars = array()) {
    return $this->doDelete($formConfigId, $entryId, $queryVars);
  }

  public function fetchList($formConfigId, $entry = array(), $queryVars = array())
  {
    return $this->doFetchList($formConfigId, $entry, $queryVars);
  } 


  public function getModelId($post, $formConfigId, $modelId)
  {
    return $modelId;
  }

  public function doFetchList($formConfigId, array $args = array(), $entry = array(), $modelId = 0)
  {
    $query = new \WP_Query($args);

    $entries = [];

    $theModelId = intval($modelId != 0 ? $modelId : $formConfigId);

    $count = 0;
    while ($query->have_posts()) {
      $post = $query->next_post();

      if ($theModelId == 0) {
        $theModelId = intval($this->getModelId($post, $formConfigId, $modelId));
      }

      $entries[] = $this->fromDb($post, $formConfigId, $theModelId);
      $count++;
    }

    $limit = intval($args['posts_per_page'] ?? '0');
    $pageNumber = intval($args['paged'] ?? '1');


    return $this->buildFetchListResult(
      intval($query->post_count),
      intval($query->found_posts),
      ($limit === 0 || $limit == -1) ? 1 : intval($query->max_num_pages),
      $pageNumber,
      $entries,
      $entry
    );
  }

  public function getFieldListByModelId($modelId): array
  {
    return FieldConfigModel::getInstance()->getListByName($modelId);
  }

  protected final function buildFetchListResult(int $countEntries, int $totalEntries, int $totalPages, int $pageNumber, array $entries,  array $currentEntry = array()): array
  {
    return PostUtils::getInstance()->buildFetchListResult($countEntries, $totalEntries, $totalPages, $pageNumber, $entries,  $currentEntry);
  }

  protected final function buildEmptyFetchListResult(): array
  {
    return PostUtils::getInstance()->buildEmptyFetchListResult();
  }

  public function validateForm(int $formConfigId, int $entryId, array $requestData, array &$errors) {
    
  }
}
