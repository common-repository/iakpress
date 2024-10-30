<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of PluginInterface
 *
 * @author bly
 */
class BaseController extends AbstractController {
    const VALUES_KEY  = 'values';
    const DATA_KEY  = 'data';
    const CHOICE_KEY = 'choice';
    const LIST_DATA = 'listData';
    const POST_CONFIG = 'formConfig';
    const ENTRY_ID_KEY = 'entry_id';

    const ACCESS_DENIED_ERR =
        'Access Denied. You do not have permission to access this page.';

    /**
     * Constructor
     */
    public function __construct() {
    }

    public function notFound() {
        return new JsonResponse(['err_msg' => 'Not Found'], 404);
    }

    public function accessDenied() {
        return new JsonResponse(['err_msg' => self::ACCESS_DENIED_ERR], 403);
    }

    public function getCurrentRouteUrl($relativePath) {
        $siteUrl = PluginInterface::getInstance()->getSiteUrl();

        return $siteUrl. $relativePath;
    }

    public function checkAccessControl() {
       /*if (PluginInterface::getInstance()->getIsDevEnv()) {
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
                header("Access-Control-Max-Age: 86400");
       }*/
    }

    public function renderTemplate($template, $childPostType = '', array $dataItems = array()) {
        return PluginInterface::getInstance()->renderTemplate($template,  $childPostType, $dataItems);
    }
    
    public final function addPostAdmin(AbstractPostEntryAdmin $formAdmin) {
        PluginInterface::getInstance()->addPostAdmin($formAdmin);
    }

    public final function getPostAdminList(): array {
        return PluginInterface::getInstance()->getPostAdminList();
    }
    
    public final function getPostAdminByPostType($postType) {
        return PluginInterface::getInstance()->getPostAdminByPostType($postType);
    }

    public function getTwig(): \Twig\Environment {
        return PluginInterface::getInstance()->getTwig();
    }

    protected function getEntityManager() {
        return $this->getDoctrine()->getManager();
    }
}
