<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;


use App\Joosorol\IAKPress\IAPost\Constants;

/**
 *
 * @author bly
 */
abstract class AbstractPostConfigAdmin extends  AbstractPostAdmin {
    const POST_TYPE = Constants::IA_POST_CONFIG_POST_TYPE;

    public function shouldHavePostConfigId() {
        return FALSE;
    }
    
    public final function registerPostType() {
        $this->doRegisterPostType();
    }

    public final function registerShortCode() {
        $this->doRegisterShortCode();
    }

    public final function render($post) {
        if ($this->getInputPostType() == self::POST_TYPE) {
            $this->doRender($post);
        }
    }
}
