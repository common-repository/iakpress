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

use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAPostType\PhotoGalleryPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\PostConfig;

class PhotoGalleryModel extends GenericEntryModel
{
    /**
     * @var PhotoGalleryModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * PhotoGalleryModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main PhotoGalleryModel Instance
     *
     * Ensures only one instance of PhotoGalleryModel is loaded or can be loaded.
     *
     * @static
     * @return PhotoGalleryModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        return Constants::IA_PHOTO_GALLERY_POST_TYPE;
    }

    public function getFieldListByModelId($modelId) : array {
        $obj = new PhotoGalleryPostType();
        return ($obj->toArray())[PostConfig::FIELDS] ?? array();
    }

    public function fromDb($post, $formConfigId = 0, $modelId = 0): array
    {
        $meta = $this->getMeta($post, $formConfigId, $modelId);
  
        return array_merge(
            [
                SubPostType::ID => $post->ID,
                SubPostType::POST_CONFIG_PARENT_ID => $post->post_parent,
                SubPostType::TITLE => $post->post_title,
                SubPostType::NAME => $post->post_name,
                SubPostType::MENU_ORDER => $post->menu_order
            ],
            $meta
        );
    }

    protected function getQueryArgs($formConfigId, $entry = array(), $queryVars = array()) : array {
        $args = [
            'post_type' => $this->getPostType(),
            'posts_per_page'   => -1
        ];

        $modelId = intval($queryVars[Constants::MODEL_ID] ?? '0');

        $args = array_merge($args, $this->getMetaQueryArgs($modelId, $queryVars));

        return $args;
    }
}