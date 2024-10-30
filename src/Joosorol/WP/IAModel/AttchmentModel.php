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
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAPostType\AttachmentPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\Imagine\ImageFilter;

class AttchmentModel extends GenericEntryModel
{
    /**
     * @var AttchmentModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * @var ImageFilter
     */
    private static ?ImageFilter $sImageFilter = null; 

    /**
     * AttchmentModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main AttchmentModel Instance
     *
     * Ensures only one instance of AttchmentModel is loaded or can be loaded.
     *
     * @static
     * @return AttchmentModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * @required
     */
    public static function setImageFilter($imageFilter): void
    {
        self::$sImageFilter = $imageFilter;
    }


    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        return Constants::IA_ATTACHMENT_POST_TYPE;
    }

    public function getUniqueFields($formConfigId, array $requestData) : array {
        return array();
    }

    public function getFieldListByModelId($modelId) : array {
        $obj = new AttachmentPostType();
        $fields = ($obj->toArray())[PostConfig::FIELDS] ?? array();
        return $fields;
    }

    public function fromDb($post, $formConfigId = 0, $modelId = 0): array
    {
        $meta = $this->getMeta($post, $formConfigId, $modelId);
  
        $url = wp_get_attachment_url($post->ID);
        $meta[Option::FILE_PATH] = $url;

        $attachment = wp_get_attachment_metadata($post->ID);
        if (!empty($attachment)) {
            if (isset($attachment[Constants::FILE]) && wp_attachment_is_image($post)) {
                $meta[Constants::FPATH_THUMBNAIL] =  self::$sImageFilter->getThumbnailImageUrl($modelId, $attachment[Constants::FILE],  $url);
                $meta[Constants::FPATH_LARGE] =  self::$sImageFilter->getLargeImageUrl($modelId, $attachment[Constants::FILE],  $url);
            }
        }


        return array_merge(
            [
                SubPostType::ID => $post->ID,
                SubPostType::TITLE => html_entity_decode($post->post_title),
                SubPostType::NAME => $post->post_name
            ],
            $meta
        );
    }

    protected function getQueryArgs($formConfigId, $entry = array(), $queryVars = array()) : array {
        $limit = Constants::ATTACHMENT_LIMIT;

        $pageNumber = intval($queryVars[Constants::PAGE_NUMBER] ?? 1);

        $args = [
            'post_type' => $this->getPostType($formConfigId),
            'post_status' => 'inherit',
            'paged' => $pageNumber,
            'posts_per_page'   => $limit,
            'orderby' => 'post_modified',
            'order' =>  $queryVars[Option::ITEMS_ORDER_DIRECTION] ?? 'DESC'
        ];

        if ( current_user_can( get_post_type_object( 'attachment' )->cap->read_private_posts ) ) {
            $args['post_status'] .= ',private';
        }

        if (isset($queryVars['post_mime_type'])) {
            $args['post_mime_type'] = $queryVars['post_mime_type'];
        }


        if (isset($queryVars['s'])) {
            $args['s'] = $queryVars['s'];
        }


        return $args;
    }
}