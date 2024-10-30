<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\PostUtils;

/**
 *
 * @author bly
 */
abstract class AbstractPostAdmin {
    private $inputPostType = null;

    private $formAdminChildren = array();

    public final function getInputPostType() {
        return $this->inputPostType;
    }

    public final function setInputPostType($val) {
        $this->inputPostType = $val;
    }

	public function hasEntries($postId) {
		return PostUtils::getInstance()->hasEntries($postId);
	}
	

    public final function getCurrentFormConfig() {       
        return PostUtils::getInstance()->fetchFormConfigById(0);
    }

    public final function setCurrentPostConfig($val) {
        $this->currentPostConfig = $val;
    }
    
    public function renderTemplate($template, $postType = '', array $dataItems = array()) {
        return PluginInterface::getInstance()->renderTemplate($template, $postType, $dataItems);
    }

    public final function init() {
        $this->doInit();
    }

    abstract public function shouldHavePostConfigId();

    public final function addPostAdmin(AbstractPostAdmin $formAdmin) {
        $this->formAdminChildren[$formAdmin->getName()] = $formAdmin;
    }

    public final function getPostAdminChildren() {
        return $this->formAdminChildren;
    }

    abstract protected function doInit();

    abstract function getPostType() : string;

    abstract public function getName() : string;

    protected function doRegisterPostType() {

    }
    
    
    protected function doAdminNotices() {

    }
    
    protected function doRegisterShortCode() {

    }
    
    protected function doRender($post) {

    }
}