<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\WP\Admin;

use App\Joosorol\IAKPress\IAPost\AbstractPostEntryAdmin;

/**
 *
 * @author bly
 */
abstract class DefaultPostEntryAdmin extends AbstractPostEntryAdmin {        
    protected function doInit() {
        add_action('init', array($this, 'registerPostType'));

        //add_action('add_meta_boxes', array($this, 'addCustomMetaBoxes'));        
    }

    public function shouldHavePostConfigId() {
        return TRUE;
    }
}
