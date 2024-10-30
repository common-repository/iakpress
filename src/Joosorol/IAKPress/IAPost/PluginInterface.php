<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAPost;

/**
 * Description of PluginInterface
 *
 * @author bly
 */
class PluginInterface extends PluginInterfaceBase {

    // Define constants
    const VERSION = '1.3.2';
    
    /**
     * @var PluginInterface The single instance of the class
     */
    private static $sInstance = null;


    /**
     * Main PluginInterface Instance
     *
     * Ensures only one instance of PluginInterface is loaded or can be 
     * loaded.
     *
     * @static
     * @return PluginInterface - Main instance
     */
    public static function getInstance() {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * Constructor
     */
    protected function __construct() {
       parent::__construct();
    }
}
