<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\WP\WPPostUtils;

class PostUtils extends PostUtilsInterface
{
    /**
     * @var PostUtils The single instance of the class
     */
    private static $sInstance = null;


    private PostUtilsInterface $_impl;

    private $_isWebpSupported = false;


    /**
     * PostUtils Constructor.
     */
    private function __construct()
    {
        if (defined('IAK_SYMFONY')) {
            $this->_impl = new SymfPostUtils();
        } else {
            $this->_impl = new WPPostUtils();
        }
    }

    /**
     * Main PostUtils Instance
     *
     * Ensures only one instance of PostUtils is loaded or can be loaded.
     *
     * @static
     * @return PostUtils - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function buildMediaIdFieldName (string $fieldName) : string {
        return $fieldName. "_". Constants::MEDIA_ID;
    }

    public final function buildFetchListResult(int $countEntries, int $totalEntries, int $totalPages, int $pageNumber, array $entries,  array $currentEntry = array()) : array {
        return [
          Constants::COUNT => $countEntries,
          Constants::TOTAL => $totalEntries,
          Constants::ENTRIES => $entries,
          Constants::ENTRY => $currentEntry,
          Constants::TOTAL_PAGES => $totalPages,
          Constants::PAGE_NUMBER => $pageNumber,
          Constants::ITEMS_PER_PAGE => $countEntries
        ];
    }
  
    public final function buildEmptyFetchListResult() : array {
      return [
        Constants::COUNT => 0,
        Constants::TOTAL => 0,
        Constants::ENTRIES => [],
        Constants::ENTRY => [],
        Constants::TOTAL_PAGES => 0,
        Constants::PAGE_NUMBER => 0,
        Constants::ITEMS_PER_PAGE => 0
      ];
    }

    public function hasGd() {
        return !(!function_exists('gd_info') || !defined('GD_VERSION'));
    }

    public function setIsWebpSupported(bool $val) {
        $this->_isWebpSupported = $val;
    }

    public function getIsWebpSupported() {
        return $this->_isWebpSupported;
    }

    public function getUserCanManage() {
        return $this->_impl->getUserCanManage();
    }

    public function hasBlocks() {
        return $this->_impl->hasBlocks();
    }

    public function isAdmin() : bool {
        return $this->_impl->isAdmin();
    }
    
    public function getCurrentUser() : ?User
    {
        return $this->_impl->getCurrentUser();
    }


    public function getLocale() {
       return $this->_impl->getLocale();
    }

    public function userLoggedIn()
    {
        return $this->_impl->userLoggedIn();
    }

    public function doGetRoles()
    {
        return $this->_impl->doGetRoles();
    }

    public function updatePostMeta(int $postId, string $metaKey, $metaValue)
    {
        $this->_impl->updatePostMeta($postId, $metaKey, $metaValue);
    }

    public function getPostMeta(int $postId, string $key = '', bool $single = false)
    {
        return  $this->_impl->getPostMeta($postId, $key, $single);
    }

    public function deletePostMeta(int $postId, string $key)
    {
        $this->_impl->deletePostMeta($postId, $key);
    }

    public function getPostById($id) {
        return $this->_impl->getPostById($id);
    }

    public function getPostBySlug($slug, $postType) {
        return $this->_impl->getPostBySlug($slug, $postType);
    }

    public function getCurrentTime() {
        return $this->_impl->getCurrentTime();
    }

    public function deletePost(int $postId, bool $forceDelete = false)
    {
        $this->_impl->deletePost($postId, $forceDelete);
    }

    public function updatePost(array $formData)
    {
        return $this->_impl->updatePost($formData);
    }

    public function updateUser(array $formData) {
        return $this->_impl->updateUser($formData);
    }

    public function updateTermMeta(int $postId, string $metaKey, $metaValue)
    {
        $this->_impl->updateTermMeta($postId, $metaKey, $metaValue);
    }

    public function getTermMeta(int $postId, string $key = '', bool $single = false)
    {
        return $this->_impl->getTermMeta($postId, $key, $single);
    }

    public function deleteTermMeta(int $postId, string $key)
    {
        $this->_impl->deleteTermMeta($postId, $key);
    }

    public function deleteTerm(int $postId, string $taxonomy)
    {
        $this->_impl->deleteTerm($postId, $taxonomy);
    }

    public function updateTerm(int $termId, string $taxonomy, array $formData)
    {
        $this->_impl->updateTerm($termId, $taxonomy, $formData);
    }

    public function getTermById($id, $taxonomy = null) {
        return $this->_impl->getTermById($id, $taxonomy);
    }

    public function getTerms(array $args) {
        return $this->_impl->getTerms($args);
    }

    public function getPostConfigType($postId)
    {
        return $this->_impl->getPostConfigType($postId, PostConfig::POST_CONFIG_TYPE, true);
    }

    public function setPostTerms(int $post_ID, string $taxonomy, $post_categories = array(), bool $append = false) {
        $this->_impl->setPostTerms($post_ID, $taxonomy, $post_categories, $append);
    }

    public function hasEntries($postId)
    {
       return $this->_impl->hasEntries($postId);
    }

    public function validatePublishData($formConfigType, array $data): bool
    {
        return $this->_impl->validatePublishData($formConfigType, $data);
    }

    public function getPublishPostTypeConfig($formConfigType): array
    {
        return $this->_impl->getPublishPostTypeConfig($formConfigType);
    }

    public function formatEntry(array $viewConfig, array $entry, $isArchive = false): array
    {
        return $this->_impl->formatEntry($viewConfig, $entry, $isArchive);
    }

    public function formatEntries(array $viewConfig, array $entries): array
    {
        return $this->_impl->formatEntries($viewConfig, $entries);
    }

    public function getBooleanVal($boolTtext)
    {
        return $this->_impl->getBooleanVal($boolTtext);
    }

    public function getPublicPostTypes()
    {
        return $this->_impl->getPublicPostTypes();
    }

    public function getOption(string $optionName, $default = false) {
        return $this->_impl->getOption($optionName, $default);
    }

    public function updateOption(string $optionName, $optionValue)  {
        $this->_impl->updateOption($optionName, $optionValue);
    }

    public function setStatus(
        int $entryId,
        array $requestData) {
        return $this->_impl->setStatus($entryId, $requestData);
    }

    public function countEntriesByStatusId(string $statusId) : int {
        return $this->_impl->countEntriesByStatusId($statusId);
    }

    public function fetchFormConfigById($formConfigId) {
        return  $this->_impl->fetchFormConfigById($formConfigId);
    }

    public function fetchFormConfigByName($formConfigId) {
        return  $this->_impl->fetchFormConfigByName($formConfigId);
    }

    public final function getCurrentFormConfig() {       
        return $this->fetchFormConfigById(0);
    }

    public final function getCurrentViewConfig() {
        $formConfig = $this->getCurrentFormConfig();

        if (!is_null($formConfig)) {
            $settings = $formConfig[PostConfig::POST_SETTINGS] ?? array();
            $viewId = intval ($settings[Option::CPT_VIEW_ID] ?? 0);
            if ($viewId != 0) {
                return $this->fetchFormConfigById($viewId);
            }
        }
       
        return null;
    }

    public function getPages() : array {
        return $this->_impl->getPages();
    }

    public function getDataDir() : string {
        return $this->_impl->getDataDir();
    }

    public function getDataUrl() : string {
        return $this->_impl->getDataUrl();
    }

    public function isGdLoaded() : bool {
        return extension_loaded('gd');
    }

    protected  function  getEncryptDecryptKey() : string {
        return $this->_impl->getEncryptDecryptKey();
    }

    public function getSecret() : string {
        return $this->encrypt("Fae2c9LCMf");
    }

    public function encrypt($str) {
        return Cryptor::getInstance()->encrypt($this->getEncryptDecryptKey(), $str);
    }

    public function decrypt($str) {
        return Cryptor::getInstance()->decrypt($this->getEncryptDecryptKey(), $str);
    }

    public function signOn(string $username, string $password,  bool $remember = false) : ?User {
      return $this->_impl->signOn($username, $password, $remember);
    }

    public function getUserBy($field, $value) : ?User {
        return $this->_impl->getUserBy($field, $value);
    }

    public function getUsername($username) : string {
        return $this->_impl->getUsername($username);
    }
}