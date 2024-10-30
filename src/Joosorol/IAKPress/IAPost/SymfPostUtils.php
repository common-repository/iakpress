<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

use Exception;

class SymfPostUtils  extends PostUtilsInterface
{
    public function getUserCanManage() {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function hasBlocks() {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function isAdmin() : bool {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }
    

    public function getCurrentUser() : ?User
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getLocale() {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function userLoggedIn()
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function doGetRoles()
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function updatePostMeta(int $postId, string $metaKey, $metaValue)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPostMeta(int $postId, string $key = '', bool $single = false)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function deletePostMeta(int $postId, string $key)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPostById($id) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPostBySlug($slug, $postType) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getCurrentTime() {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function deletePost(int $postId, bool $forceDelete = false)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function updatePost(array $formData)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }


    public function updateTermMeta(int $postId, string $metaKey, $metaValue)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getTermMeta(int $postId, string $key = '', bool $single = false)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function deleteTermMeta(int $postId, string $key)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function deleteTerm(int $postId, string $taxonomy)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function updateTerm(int $termId, string $taxonomy, array $formData)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getTermById($id, $taxonomy = null) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getTerms(array $args) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPostConfigType($postId)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function setPostTerms(int $post_ID, string $taxonomy, $post_categories = array(), bool $append = false) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function hasEntries($postId)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function validatePublishData($formConfigType, array $data): bool
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPublishPostTypeConfig($formConfigType): array
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function formatEntry(array $viewConfig, array $entry, $isArchive = false): array
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function formatEntries(array $viewConfig, array $entries): array
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getBooleanVal($boolTtext)
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPublicPostTypes()
    {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getOption(string $optionName, $default = false) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }


    public function setStatus(
        int $entryId,
        array $requestData) {
            throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function countEntriesByStatusId( string $statusId) : int {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function fetchFormConfigById($formConfigId) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function fetchFormConfigByName($formName) {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getPages() : array {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getDataDir() : string {
        return '.';
    }

    public function getDataUrl() : string {
        return 'http://127.0.0.1:8080/';
    }

    protected function  getEncryptDecryptKey() : string {
        return 'dummy';
    }
}