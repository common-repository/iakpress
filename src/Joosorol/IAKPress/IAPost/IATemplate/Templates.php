<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;


class Templates {
    /**
     * @var array
     */
    private $types;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = array();
        $this->types[PTContactForm::TYPE_VALUE] = (new PTContactForm())->toArray();
        $this->types[PTPhotoGallery::TYPE_VALUE] = (new PTPhotoGallery())->toArray();

        $this->types[PTAdvancedForm::TYPE_VALUE] = (new PTAdvancedForm())->toArray();

        $this->types[PTProductListViewForm::TYPE_VALUE] = (new PTProductListViewForm())->toArray();
        $this->types[PTCustomListViewForm::TYPE_VALUE] = (new PTCustomListViewForm())->toArray();

        $this->types[PTSignupForm::TYPE_VALUE] = (new PTSignupForm())->toArray();
        $this->types[PTSessionForm::TYPE_VALUE] = (new PTSessionForm())->toArray();
        $this->types[PTOrderForm::TYPE_VALUE] = (new PTOrderForm())->toArray();


        $this->types[SimpleList::TYPE_VALUE] = (new SimpleList())->toArray();
        $this->types[SimpleListWithImages::TYPE_VALUE] = (new SimpleListWithImages())->toArray();
        $this->types[ProductList::TYPE_VALUE] = (new ProductList())->toArray();
        $this->types[CategoryList::TYPE_VALUE] = (new CategoryList())->toArray();
        $this->types[OptionGroupList::TYPE_VALUE] = (new OptionGroupList())->toArray();

        
        /*
        Not Implemented Yet
        $this->types[PTApiGoogleClient::TYPE_VALUE] = (new PTApiGoogleClient())->toArray();
        */
        $this->types[PTApiPaypal::TYPE_VALUE] = (new PTApiPaypal())->toArray();
        $this->types[PTApiStripe::TYPE_VALUE] = (new PTApiStripe())->toArray();
        $this->types[PTApiSmtp::TYPE_VALUE] = (new PTApiSmtp())->toArray();
    }

    public function toArray() {
        return $this->types;
    }

    public static function getParentTypeId($typeId)
    {
        return floor(intval($typeId) / 100);
    }
}