<?php

/*
 * This file is part of iaklm package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IATemplate;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

class PostTypeUtils {
    const TITLE_FIELD = Option::TITLE;
    const DESC_FIELD = Option::DESC;
    const SLUG_FIELD = Option::SLUG;
    const EMAIL_FIELD = Option::EMAIL;

	public static function getTemplate($modelType) : ?BaseTemplate {
        switch ($modelType) {
        case  TemplateTypes::FT_MODEL_SIMPLE_LIST:
            return new SimpleList();

        case  TemplateTypes::FT_MODEL_HIERARCHICAL_LIST:
            return new HierarchicalList();

        case  TemplateTypes::FT_MODEL_SIMPLE_LIST_WITH_IMAGES:
            return new SimpleListWithImages();

        case  TemplateTypes::FT_MODEL_HIERARCHICAL_LIST_WITH_IMAGES:
            return new HierarchicalListWithImages();

        case  TemplateTypes::FT_MODEL_SIMPLE_PRODUCT_LIST:
            return new SimpleProductList();

        case  TemplateTypes::FT_MODEL_CATEGORY_LIST:
        case  TemplateTypes::FT_MODEL_TAG_LIST:
            return new CategoryList();

        case  TemplateTypes::FT_MODEL_OPTION_GROUP_LIST:
            return new OptionGroupList();
        
        case  TemplateTypes::FT_MODEL_PRODUCT_LIST:
            return new ProductList();

        case TemplateTypes::FT_MODEL_CUSTOM_LIST:
            return new CustomList();

        case TemplateTypes::FT_PRODUCT_LIST_VIEW_FORM:
            return new PTProductListViewForm();
        
        case TemplateTypes::FT_SIGN_UP_FORM:
            return new PTSignupForm();

        case TemplateTypes::FT_ADVANCED_FORM:
            return new PTAdvancedForm();

        case TemplateTypes::FT_ORDER_FORM:
            return new PTOrderForm();

        case TemplateTypes::FT_SESSION_FORM:
            return new PTSessionForm();

        case TemplateTypes::FT_PHOTO_GALLERY:
            return new PTPhotoGallery();
        
        case TemplateTypes::FT_CONTACT_FORM:
            return new PTContactForm();
        
        case TemplateTypes::FT_CUSTOM_LIST_VIEW_FORM:
            return new PTCustomListViewForm();


        default:
            return null;
        }
    }

    public static function buildFieldSlug($modelName, $fieldName) {
        return sprintf("%s_%s", $modelName, $fieldName);
    }

    public static function getSupports($type) : array {
        $modelTpl = self::getTemplate($type);

        if (!is_null($modelTpl)) {
            return $modelTpl->getSupports();
        } else {
            return array('title', 'editor');
        }
    }

    public static function formatPostTypeEntries($modelType, array $data): array
    {
        $entries =  $data[Constants::ENTRIES] ?? array();

        $theModelType = intval($modelType);

        $res = array();

        foreach ($entries as $k => $v) {
            $res[$v[Option::ID]]  = $v;
        }

        return $res;
    }
}
