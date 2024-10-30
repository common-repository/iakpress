<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\WP\Admin;

use App\Joosorol\IAKPress\IAPost\AbstractPostConfigAdmin;

/**
 *
 * @author bly
 */
abstract class DefaultPostConfigAdmin extends AbstractPostConfigAdmin {    
    const PAGE_POST_TYPE_SUFFIX = 'page';

    protected function doInit() {
        add_action('init', array($this, 'registerPostType'));    
    }

    public function showPage() {
        echo 'In Progress....';
    }
}
