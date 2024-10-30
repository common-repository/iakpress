<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

/**
 * Description of AbstractPostEntryAdmin
 *
 * @author bly
 */
abstract class AbstractPostEntryAdmin extends AbstractPostAdmin {
    public final function registerPostType() {
        $this->doRegisterPostType();
    }

    public final function registerShortCode() {
        $this->doRegisterShortCode();
    }

    public final function render($post) {
        $this->doRender($post);
    }    
}
