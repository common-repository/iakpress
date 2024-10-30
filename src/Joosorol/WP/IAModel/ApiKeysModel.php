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

use App\Joosorol\IAKPress\IAPost\ClientConfig;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use  App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IATemplate\ApiKeysUtils;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostUtils;

class ApiKeysModel extends PostConfigModel
{
    /**
     * @var ApiKeysModel The single instance of the class
     */
    private static $sInstance = null;

    /**
     * ApiKeysModel Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main ApiKeysModel Instance
     *
     * Ensures only one instance of ApiKeysModel is loaded or can be loaded.
     *
     * @static
     * @return ApiKeysModel - Main instance
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
        return Constants::IA_API_KEYS_POST_TYPE;
    }

    protected function doGetApiKeysByType() : array {
        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'post_modified',
            'order' => 'DESC',
            'posts_per_page'   => -1
        ];

        $query = new \WP_Query($args);

        $res = array();
        while ($query->have_posts()) {
            $post = $query->next_post();

            $entry = $this->fromDb($post, 0);
            $this->getPostFields($post->ID, $entry);

            $fields = $entry[PostConfig::FIELDS] ?? array();
            $params = $fields[Option::PARAMS] ?? array();

            $enabled = PostUtils::getInstance()->getBooleanVal($params[Option::ENABLED] ?? false);

            if ($enabled) {
                $apiKeyType = $entry[PostConfig::POST_CONFIG_TYPE];

                $res[$apiKeyType] = $entry;
            }
        }

        return $res;
    }

    protected static function getApiKeysListByType() : array {
        static  $res;

        if (!$res) {
            $res = self::getInstance()->doGetApiKeysByType();
        }
       
        return $res;
    }

    public static function getApiParamsByType($type) : array {
       $apiKeysListByType = self::getApiKeysListByType();

       $apiKeys = $apiKeysListByType[$type] ?? array();

       $fields = $apiKeys[PostConfig::FIELDS] ?? array();
       $params = $fields[Option::PARAMS] ?? array();

       return $params;
    }

    public function createApiKeys() {
        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'post_modified',
            'order' => 'DESC',
            'posts_per_page'   => -1
        ];

        $query = new \WP_Query($args);

        $alreadyFoundList = [];
        $duplicatedList = [];

        while ($query->have_posts()) {
            $post = $query->next_post();

            $entry = $this->fromDb($post, 0);
            
            $apiKeyType = $entry[PostConfig::POST_CONFIG_TYPE];
            $apiKeyId = $entry[PostConfig::POST_CONFIG_ID];

            if (isset($alreadyFoundList[$apiKeyType])) {
                $duplicatedList[] = $apiKeyId;
            } else {
                $alreadyFoundList[$apiKeyType] =$apiKeyId;
            }
        }

        // remove duplicated entries
        foreach($duplicatedList as $id) {
            $this->doDelete(0, $id);
        }

        // add api keys entries
        foreach(ClientConfig::API_KEYS_TAB as $values) {
            $key = intval($values[Option::TYPE] ?? 0);
            if ($key != 0 && !isset($alreadyFoundList[$key])) {
                $post = $this->doEdit(0, 0, $values);          
            }
        }
    }

   /**
     * Called each time a formConfig is created
     */
    protected function onCreated($post, $templateType, $fieldType = 0) {
        $postId = $post->ID;

        $modelTpl = ApiKeysUtils::getTemplate($templateType);

        if (!is_null($modelTpl)) {
            $defaultFields = $modelTpl->getConfig();
            
            $orderNum = 0;
            foreach ($defaultFields as $field) {
                $field[SubPostType::MENU_ORDER] = $orderNum;
                $field[Option::DELETABLE] = 'false';
                
                FieldConfigModel::getInstance()->doEdit($postId, 0, $field);

                $orderNum++;
            }
            
            $this->updatePostMeta($postId, Option::ENTRY_TITLE, ApiKeysUtils::TITLE_FIELD);
            $this->updatePostMeta($postId, Option::ENTRY_CONTENT, ApiKeysUtils::DESC_FIELD);
            $this->updatePostMeta($postId, PostConfig::POST_CONFIG_PUBLISHED, 'true');
        }
    }
    

    public function fetchList($formConfigId, $entry = array(), $queryVars = array())
    {
        $args = [
            'post_type' => $this->getPostType(),
            'orderby' => 'post_modified',
            'order' => 'DESC',
            'posts_per_page'   => -1
        ];

        if (PostUtils::getInstance()->getUserCanManage()) {
            $result = $this->doFetchList($formConfigId,  $args, $entry);
    
            $this->getPostListFields($result);

            $entries = isset($result[Constants::ENTRIES]) ? $result[Constants::ENTRIES] : array();

            // should not return password
            foreach($entries as $key => $entry) {
                if (isset($entry[PostConfig::FIELDS]) && isset($entry[PostConfig::FIELDS][Option::PARAMS])) {
                    $entries[$key][PostConfig::FIELDS][Option::PARAMS][Option::PASSWORD] = Constants::DUMMY_PASSWORD;
                }
            }
        } else {
            $query = new \WP_Query($args);

            $entries = [];

            while ($query->have_posts()) {
                $post = $query->next_post();
    
                $entry = $this->fromDb($post, 0);
    
                $entries[$post->ID] =  [
                    PostConfig::POST_CONFIG_ID => $entry[PostConfig::POST_CONFIG_ID],
                    PostConfig::POST_CONFIG_TITLE =>  $entry[PostConfig::POST_CONFIG_TITLE],
                    PostConfig::POST_CONFIG_TYPE => $entry[PostConfig::POST_CONFIG_TYPE],
                ];
            }
    
            return $entries;
        }

        // map apikeys by type
        $res = [];
        foreach($entries as $entry) {
            $res[$entry[PostConfig::POST_CONFIG_TYPE]] = $entry;
        }

        return $res;
    }
}
