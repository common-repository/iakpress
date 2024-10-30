<?php

/*
 * This file is part of the IACAFactory package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;

use App\Joosorol\IAKPress\IAPost\PostConfig;
use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\PostData;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;

class GenericModelViewModel extends PostConfigModel
{
    /**
     * @var GenericModelViewModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * GenericModelViewModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main GenericModelViewModel Instance
     *
     * Ensures only one instance of GenericModelViewModel is loaded or can be loaded.
     *
     * @static
     * @return GenericModelViewModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function toDb(array $values, $formConfigId = 0): PostData
    {
        $formData = new PostData();

        $formData->setPostType($this->getPostType());
        $formData->setId(intval($values[PostConfig::POST_CONFIG_ID] ?? '0'));
        $formData->setPostTitle(trim($values[PostConfig::POST_CONFIG_TITLE] ?? ''));

        if (strlen($formData->getPostTitle()) < 4) {
            $formData->setIsValid(false);
            return $formData;
        }

        $formData->setIsValid(true);
        return $formData;
    }

    public function enrichRequestData(array $values) {
        return array_merge($values, [Option::POST_CONFIG_TYPE => TemplateTypes::FT_PRODUCT_VIEW]);
    }

    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $limit = Constants::DEFAULT_LIMIT;
        $pageNumber  =  1;

        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'modified',
            'order' => 'DESC',
            'posts_per_page'   => $limit,
            'paged' => $pageNumber,
            'meta_query' =>   [
                [
                    'key'     => Constants::POST_CONFIG_PARENT_ID,
                    'value'   => $formConfigId,
                ]
            ]
        ];
       
        $result = $this->doFetchList($formConfigId,  $args, $entry);

        $this->getPostListFields($result);

        return $result;
    }
}
