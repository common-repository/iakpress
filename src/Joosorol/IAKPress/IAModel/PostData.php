<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAModel;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IAPostType\SubPostType;

class PostData {
    const ID = 'ID';
    const POST_TITLE = 'post_title';
    const POST_CONTENT = 'post_content';
    const NAV_MENU_ORDER = 'menu_order';
    const POST_EXCERPT = 'post_excerpt';
    const POST_TYPE = 'post_type';
    const POST_STATUS = 'post_status';
    const POST_AUTHOR = 'post_author';
    const POST_PARENT = 'post_parent';
    const POST_NAME = 'post_name';

     /**
     * @var array
     */
    private $values = array();

    /**
     * @var array
     */
    private $meta = array();

    /**
     * @boolean
     */
    private $isValid = False;

    private $templateId = 0;

    /**
     * Constructor
     */
    public function __construct() {
        $this->values[self::ID] = 0;
        $this->values[self::POST_TITLE] = '';
        $this->values[self::POST_CONTENT] = '';
        $this->values[self::NAV_MENU_ORDER] = 0;
        $this->values[self::POST_EXCERPT] = '';
        $this->values[self::POST_TYPE] = '';
        $this->values[self::POST_STATUS] = 'publish';
        $this->values[self::POST_AUTHOR] = 1;
        $this->values[self::POST_PARENT] = 0;
        $this->values[self::POST_NAME] = '';
    }

    public function setTemplateId($templateId) {
        $this->templateId = $templateId;
        return $this;
    }

    public function getTemplateId() {
        return $this->templateId;
    }

    public function setId($val) {
        $this->values[self::ID] = $val;
        return $this;
    }

    public function getId() {
        return $this->values[self::ID];
    }

    public function setPostTitle($val) {
        $this->values[self::POST_TITLE] = $val;
        return $this;
    }

    public function getPostTitle() {
        return $this->values[self::POST_TITLE];
    }

    public function setPostType($val) {
        $this->values[self::POST_TYPE] = $val;
        return $this;
    }

    public function getPostType() {
        return $this->values[self::POST_TYPE];
    }

    public function setPostStatus($val) {
        $this->values[self::POST_STATUS] = $val;
        return $this;
    }

    public function getPostStatus() {
        return $this->values[self::POST_STATUS];
    }

    public function setPostAuthor($val) {
        $this->values[self::POST_AUTHOR] = $val;
        return $this;
    }

    public function getPostAuthor() {
        return $this->values[self::POST_AUTHOR];
    }

    public function setPostParent($val) {
        $this->values[self::POST_PARENT] = $val;
        return $this;
    }

    public function getPostParent() {
        return $this->values[self::POST_PARENT];
    }

    public function setPostContent($val) {
        $this->values[self::POST_CONTENT] = $val;
        return $this;
    }

    public function getPostContent() {
        return $this->values[self::POST_CONTENT];
    }

    public function setMenuOrder($val) {
        $this->values[self::NAV_MENU_ORDER] = $val;
        return $this;
    }

    public function getMenuOrder() {
        return $this->values[self::NAV_MENU_ORDER];
    }

    public function setPostExcerpt($val) {
        $this->values[self::POST_EXCERPT] = $val;
        return $this;
    }

    public function getPostExcerpt() {
        return $this->values[self::POST_EXCERPT];
    }

    public function setIsValid($val) {
        $this->isValid = $val;
    }

    public function getIsValid() {
        return $this->isValid;
    }
    
    public function getValues() : array {
        return $this->values;
    }

    public function setMetaValues(array $values) {
        unset($values[SubPostType::CREATED_AT]);
        unset($values[SubPostType::CREATED_AT_GMT]);
        unset($values[SubPostType::UPDATED_AT]);
        unset($values[SubPostType::UPDATED_AT_GMT]);

        if ($this->getPostType() != Constants::IA_GENERIC_SESSION_POST_TYPE) {
            unset($values[Constants::SUBMIT_BTN_NAME]);
            unset($values[Constants::SUBMIT_BTN_TYPE]);    
        }

        unset($values[Constants::PREV_ENTRY]);
        unset($values[Constants::NEXT_ENTRY]);
        unset($values[SubPostType::MENU_ORDER]);

        // unset dummy password value
        if (isset($values[Option::PASSWORD]) && $values[Option::PASSWORD] == Constants::DUMMY_PASSWORD) {
            unset($values[Option::PASSWORD]);
        }
        
        $this->meta = $values;
    }

    public function getMetaValues() : array {
        return $this->meta;
    }

    public function setPostName($val) {
        $this->values[self::POST_NAME] = $val;
        return $this;
    }

    public function getPostName() {
        return $this->values[self::POST_NAME];
    }
}