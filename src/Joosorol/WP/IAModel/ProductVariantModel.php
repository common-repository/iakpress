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
use App\Joosorol\IAKPress\IAPost\IAPostType\ProductVariantPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\PostConfig;

class ProductVariantModel extends GenericEntryModel
{
    /**
     * @var ProductVariantModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * ProductVariantModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main ProductVariantModel Instance
     *
     * Ensures only one instance of ProductVariantModel is loaded or can be loaded.
     *
     * @static
     * @return ProductVariantModel - Main instance
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
        return Constants::IA_PRODUCT_VARIANT_POST_TYPE;
    }

    public function getUniqueFields($formConfigId, array $requestData) : array {
        return array();
    }

    public function getFieldListByModelId($modelId) : array {
        $obj = new ProductVariantPostType();
        $fields = ($obj->toArray())[PostConfig::FIELDS] ?? array();
        return $fields;
    }

    public function fromDb($post, $formConfigId = 0, $modelId = 0): array
    {
        $meta = $this->getMeta($post, $formConfigId, $modelId);
  
        return array_merge(
            [
                SubPostType::ID => $post->ID,
                SubPostType::POST_CONFIG_PARENT_ID => $post->post_parent,
                SubPostType::TITLE => html_entity_decode($post->post_title),
                Option::DESC => $post->post_content,
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