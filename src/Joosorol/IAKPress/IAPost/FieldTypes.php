<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\SelectSliderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Checkbox\SelectCheckboxType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\BasicField\SelectBFType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Choice\SelectChoiceType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Media\SelectMediaType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\TextEditor\SelectTextEditorType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\ContainerField\SelectContainerSectionType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Action\SelectActionType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\ApiConfig\SelectApiConfigType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Color\SelectColorType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\FormButton\SelectFormButtonType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\CartButton\SelectCartButtonType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\FieldOption\SelectFieldOptionType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\StepperButton\SelectStepperButtonType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Question\SelectQuestionType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\SmartField\SelectSFType;

class FieldTypes {    
    /**
     * @var array
     */
    private $fieldTypes;

    /**
     * @var array
     */
    private $blockTypes;


    /**
     * @var FieldTypes The single instance of the class
     */
    private static $sInstance = null;

    /**
     * Main FieldTypes Instance
     *
     * Ensures only one instance of FieldTypes is loaded or can be loaded.
     *
     * @static
     * @return LicenseModel - Main instance
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
    private function __construct()
    {
        $this->fieldTypes = array();
        $this->blockTypes = array();

        SelectBFType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectCheckboxType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectFormButtonType::addTypes($this->fieldTypes, $this->blockTypes);
        
        SelectMediaType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectTextEditorType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectSliderType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectChoiceType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectStepperButtonType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectContainerSectionType::addTypes($this->fieldTypes, $this->blockTypes);
        
        SelectActionType::addTypes($this->fieldTypes, $this->blockTypes);
        
        SelectSFType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectApiConfigType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectQuestionType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectColorType::addTypes($this->fieldTypes, $this->blockTypes);

        SelectCartButtonType::addTypes($this->fieldTypes, $this->blockTypes);
    }

    public function getFieldTypes() {
        return $this->fieldTypes;
    }

    public function getBlockTypes() {
        if (PostUtils::getInstance()->getUserCanManage()) {
            return $this->blockTypes;
        }

        return array();
    }
}
