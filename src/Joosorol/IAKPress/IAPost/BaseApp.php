<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * Description of BaseApp
 *
 * @author bly
 */
abstract class BaseApp {
    private $inputPostType = null;
    private $inputPostId= null;

    private ?Request $request = null;

    public final function getInputPostType() {
        return $this->inputPostType;
    }

    public final function setInputPostType($val) {
        $this->inputPostType = $val;
    }

    public final function getCurrentFormConfig() {
        PostUtils::getInstance()->getCurrentFormConfig();
    }

    public final function addPostAdmin(AbstractPostAdmin $formAdmin) {
        PluginInterface::getInstance()->addPostAdmin($formAdmin);
    }

    public final function getPostAdminList(): array {
        return PluginInterface::getInstance()->getPostAdminList();
    }
    
    public final function getPostAdminByPostType($postType) {
        return PluginInterface::getInstance()->getPostAdminByPostType($postType);
    }
    
    public function renderTemplate($template, $postType = '', array $dataItems = array()) {
        return PluginInterface::getInstance()->renderTemplate($template,  $postType, $dataItems);
    }

    abstract public function addAdminMenuPage();

    /**
     * Init application
     */
    public final function init() {
        $this->inputPostType = filter_input(INPUT_GET, 'post_type');
        if (is_null($this->inputPostType)) {
            $this->inputPostType = filter_input(INPUT_POST, 'post_type');
        }

        foreach ($this->getPostAdminList() as $postType => $formAdmin) {            
            $formAdmin->setInputPostType($this->inputPostType);
            
            $formAdmin->init();
        }

        $this->doInit();
    }


    abstract public function doInit();

    abstract public function handleAction();


     public function getBodyClasses($bodyClasses) {
        return $bodyClasses;
     }

    /**
     * Create request
     * @return Request
     */
    public function getOrCreateRequest(): Request {
        // create the request
        if (is_null($this->request)) {
            $this->request = Request::createFromGlobals();
        }
       
        return $this->request;
    }

    /**
     * Handle http request
     * @return Response the http response
     */
    abstract public function handle();
       

    /**
     * Handle http request, send the response to the client and terminate the script
     */
    abstract public function handleAndTerminate();

}
