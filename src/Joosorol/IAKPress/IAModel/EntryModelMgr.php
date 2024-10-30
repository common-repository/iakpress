<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAModel;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\Symf\SymfEntryModelMgr;
use App\Joosorol\WP\IAModel\WPEntryModelMgr;

class EntryModelMgr
{
    
   /**
     * @var EntryModelMgr The single instance of the class
     */
    private static $sInstance = null;

    private EntryModelMgrInterface $_impl;

    /**
     * EntryModelMgr Constructor.
     */
    private function __construct()
    {
        if (defined("IAK_SYMFONY")) {
            $this->_impl = new SymfEntryModelMgr();
        } else {
            $this->_impl = new WPEntryModelMgr();
        }
    }

    /**
     * Main EntryModelMgr Instance
     *
     * Ensures only one instance of EntryModelMgr is loaded or can be loaded.
     *
     * @static
     * @return EntryModelMgr - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function getModelByPostType($postType, $formConfigId = 0, $templateId = 0) : ?ContentModel
    {
        if ($this->_impl != null) {
            return $this->_impl->getModelByPostType($postType, $formConfigId, $templateId);
        }

        return null;
    }

    public function fieldModel() : ?FieldConfigModelInterface {
        return $this->getModelByPostType(Constants::IA_FIELD_POST_TYPE);
    }

    public function postConfigModel() : ?PostConfigModelInterface {
        return $this->getModelByPostType(Constants::IA_POST_CONFIG_POST_TYPE);
    }

    public function choiceGroupModel() : ?ChoiceGroupModelInterface {
        return $this->getModelByPostType(Constants::IA_GENERIC_MODEL_POST_TYPE);
    }

    public function genericEntryModel() : ?ContentModel {
        return $this->getModelByPostType(Constants::IA_GENERIC_ENTRY_POST_TYPE);
    }

    public function genericSessionModel() : ?GenericSessionModelInterface {
        return $this->getModelByPostType(Constants::IA_GENERIC_SESSION_POST_TYPE);
    }

    public function apiKeysModel() : ?ContentModel {
        return $this->getModelByPostType(Constants::IA_API_KEYS_POST_TYPE);
    }

    public function signUpModel() : ?ContentModel {
        return $this->getModelByPostType(Constants::IA_SIGN_UP_POST_TYPE);
    }
}
