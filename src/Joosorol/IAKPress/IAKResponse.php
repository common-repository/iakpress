<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress;

/**
 * Description of IAKResponse
 *
 * @author bly
 */
class IAKResponse
{
    const IS_HOME = 'is_home';
    const IS_SINGULAR = 'is_singular';
    const IS_ARCHIVE = 'is_archive';
    const IS_SEARCH =   'is_search';
    const ARCHIVE_TITLE = 'archive_title';
    const ARCHIVE_DESCRIPTION = 'archive_description';
    const SITE_NAME = 'site_name';
    const SITE_DESC =   'site_desc';
    const SITE_URL = 'site_url';
    const SITE_POSTS = 'site_posts';
    const SITE_POSTS_NAV = 'site_posts_nav';
    const CUSTOM_LOGO = 'custom_logo';
    const POST_TYPE = 'post_type';
    const HAS_IKAPOST = 'has_iakpost';

    /**
     *
     * @var array
     * admin admin forms mapped by postType
     */
    private $attrs;


    /**
     * @var IAKResponse The single instance of the class
     */
    private static $sInstance = null;


    /**
     * Main IAKResponse Instance
     *
     * Ensures only one instance of IAKResponse is loaded or can be loaded.
     *
     * @static
     * @return IAKResponse - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

     /**
     * Constructor
     */
    protected function __construct() {          
        $this->attrs = array();
        $this->attrs[self::IS_HOME] = false;
        $this->attrs[self::IS_SINGULAR] = false;
        $this->attrs[self::IS_SEARCH] = false;
        $this->attrs[self::ARCHIVE_TITLE] = '';
        $this->attrs[self::ARCHIVE_DESCRIPTION] = '';
        $this->attrs[self::SITE_NAME] = '';
        $this->attrs[self::SITE_DESC] = '';
        $this->attrs[self::SITE_URL] = '';
        $this->attrs[self::SITE_POSTS] = array();
        $this->attrs[self::SITE_POSTS_NAV] = array();
        $this->attrs[self::CUSTOM_LOGO] = '';
        $this->attrs[self::POST_TYPE] = '';
        $this->attrs[self::HAS_IKAPOST] = false;
    }

    public function setIsHome($value) {
        $this->attrs[self::IS_HOME] = $value;
    }


    public function setIsSingular($value) {
        $this->attrs[self::IS_SINGULAR] = $value;
    }

    
    public function getIsSingular() {
        return $this->attrs[self::IS_SINGULAR];
    }


    public function setIsArchive($value) {
        $this->attrs[self::IS_ARCHIVE] = $value;
    }

    public function setIsSearch($value) {
        $this->attrs[self::IS_SEARCH] = $value;
    }

    public function setArchiveTitle($value) {
        $this->attrs[self::ARCHIVE_TITLE] = $value;
    }

    public function setArchiveDescription($value) {
        $this->attrs[self::ARCHIVE_DESCRIPTION] = $value;
    }

    public function setSiteName($value) {
        $this->attrs[self::SITE_NAME] = $value;
    }

    public function setSiteDesc($value) {
        $this->attrs[self::SITE_DESC] = $value;
    }

    public function setSiteUrl($value) {
        $this->attrs[self::SITE_URL] = $value;
    }

    public function setCustomLogo($value) {
        $this->attrs[self::CUSTOM_LOGO] = $value;
    }

    public function setPostType($value) {
        $this->attrs[self::POST_TYPE] = $value;
    }

    public function setHasIAKPost($value) {
        $this->attrs[self::HAS_IKAPOST] = $value;
    }

    public function setAttr($attrName, $attrValue)
    {
        $this->attrs[$attrName] = $attrValue;
    }

    public function getAttrs(): array
    {
        return $this->attrs;
    }

    public function addAttrs(array $attrs)
    {
        $this->attrs = array_merge($this->attrs, $attrs);
    }
}
