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

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class CustomPostTypeModel extends GenericEntryModel
{
        /**
     * @var CustomPostTypeModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * CustomPostTypeModel Constructor.
     */
    private function __construct()
    {
        
    }

    /**
     * Get the postType
     */
    public function getPostType($formConfigId = 0, $templateId = 0) {
        $postTypeSlug = $this->getPostMeta($formConfigId,  Option::CPT_NAME, true);

        return $postTypeSlug;
    }

        /**
     * Main CustomPostTypeModel Instance
     *
     * Ensures only one instance of CustomPostTypeModel is loaded or can be loaded.
     *
     * @static
     * @return CustomPostTypeModel - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    protected function getMetaQueryArgs($modelId, $queryVars = array()) : array {
        $nodeParent = $queryVars[Constants::PNODE_ID] ?? $queryVars[Constants::PNODE_ID] ?? null;
        
        $metaQuery['meta_query'] = [];
        if (!empty($nodeParent)) {
            $metaQuery['meta_query'][] =  [
                    'key'     => Constants::PNODE_ID,
                    'value'   => $nodeParent,
                ];
        }

        return $metaQuery;
    }

}