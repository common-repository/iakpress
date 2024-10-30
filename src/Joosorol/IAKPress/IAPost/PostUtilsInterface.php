<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

use Exception;

abstract class PostUtilsInterface
{
    const ENTRIES_POST_TYPE_PREFIX = Constants::ENTRIES_POST_TYPE_PREFIX;
    const FIELDS_POST_TYPE_PREFIX = Constants::FIELDS_POST_TYPE_PREFIX;
    const CHOICE_GROUPS_POST_TYPE_PREFIX = Constants::CHOICE_GROUPS_POST_TYPE_PREFIX;
    const CHOICES_POST_TYPE_PREFIX = Constants::CHOICES_POST_TYPE_PREFIX;

    public function isRequestFromLocalhost() {
        if ( $_SERVER['REMOTE_ADDR'] == '::1'
          ||  substr($_SERVER['REMOTE_ADDR'], 0, 9) == 'localhost'
          || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1'
          || substr($_SERVER['REMOTE_ADDR'],0,3) == '10.'
          || substr($_SERVER['REMOTE_ADDR'],0,7) == '192.168') {
          return true;
        } else {
          return false;
        }
    }
    
    abstract public function getUserCanManage();

    abstract public function hasBlocks();

    abstract public function isAdmin(): bool;

    abstract public function getCurrentUser() : ?User; 


    abstract public function getLocale();

    abstract public function userLoggedIn();

    abstract public function doGetRoles();

    abstract public function updatePostMeta(int $postId, string $metaKey, $metaValue);

    abstract public function getPostMeta(int $postId, string $key = '', bool $single = false);


    abstract public function deletePostMeta(int $postId, string $key);


    abstract public function getPostById($id);

    abstract public function getPostBySlug($slug, $postType);


    abstract public function getCurrentTime();

    abstract public function deletePost(int $postId, bool $forceDelete = false);


    abstract public function updatePost(array $formData);


    abstract public function updateTermMeta(int $postId, string $metaKey, $metaValue);

    abstract public function getTermMeta(int $postId, string $key = '', bool $single = false);


    abstract public function deleteTermMeta(int $postId, string $key);

    abstract public function deleteTerm(int $postId, string $taxonomy);

    abstract public function updateTerm(int $termId, string $taxonomy, array $formData);


    abstract public function getTermById($id, $taxonomy = null);

    abstract public function getTerms(array $args);

    abstract public function getPostConfigType($postId);

    abstract public function setPostTerms(int $post_ID, string $taxonomy, $post_categories = array(), bool $append = false);

    abstract public function hasEntries($postId);

    abstract public function validatePublishData($formConfigType, array $data);

    abstract public function getPublishPostTypeConfig($formConfigType): array;

    abstract public function formatEntry(array $viewConfig, array $entry, $isArchive = false): array;

    abstract public function formatEntries(array $viewConfig, array $entries): array;


    abstract public function getBooleanVal($boolTtext);

    abstract public function getPublicPostTypes();

    abstract public function getOption(string $optionName, $default = false);

    abstract public function setStatus(int $entryId,  array $requestData);

    abstract public function countEntriesByStatusId(
        string $statusId
    ): int;

    abstract public function fetchFormConfigById($formConfigId);

    abstract public function fetchFormConfigByName($formName);


    abstract public function getPages() : array;

    abstract public function getDataDir() : string;

    abstract public function getDataUrl() : string;

    abstract protected function  getEncryptDecryptKey() : string;

    public function signOn(string $username, string $password, bool $remember = false) : ?User {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getUserBy($field, $value) : ?User {
      throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function getUsername($username) : string {
      throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function updateOption(string $optionName, $optionValue)  {
      throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }

    public function updateUser(array $formData) {
      throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }
}
