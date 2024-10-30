<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\WP\IAModel;


use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAModel\ContentModel;
use App\Joosorol\IAKPress\IAModel\EntryModelMgrInterface;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use Exception;

class WPEntryModelMgr extends EntryModelMgrInterface
{
    public function getModelByPostType($postType, $formConfigId = 0, $templateId = 0) : ?ContentModel
    {
        $theTemplateId = intval($templateId);
        
        if ($theTemplateId == 0 && intval($formConfigId) != 0) {
            $theTemplateId = PostUtils::getInstance()->getPostMeta($formConfigId, PostConfig::POST_CONFIG_TYPE, true);
        }

        switch ($postType) {
            case Constants::IA_GENERIC_MODEL_POST_TYPE:
                return ChoiceGroupModel::getInstance();

            case Constants::IA_POST_VIEW_POST_TYPE:
                return GenericModelViewModel::getInstance();

            case Constants::IA_API_KEYS_POST_TYPE:
                return ApiKeysModel::getInstance();

            case Constants::IA_POST_CONFIG_POST_TYPE:
                return PostConfigModel::getInstance();

            case Constants::IA_FIELD_POST_TYPE:
                return FieldConfigModel::getInstance();

            case Constants::IA_PHOTO_GALLERY_POST_TYPE:
                return PhotoGalleryModel::getInstance();

            case Constants::IA_PRODUCT_VARIANT_POST_TYPE:
                return ProductVariantModel::getInstance();

            case Constants::IA_LINKED_PRODUCT_POST_TYPE:
                return LinkedProductModel::getInstance();

            case Constants::IA_ATTACHMENT_POST_TYPE:
                return AttchmentModel::getInstance();

            case Constants::IA_GENERIC_SESSION_POST_TYPE:
                return GenericSessionModel::getInstance();

            case Constants::IA_SIGN_UP_POST_TYPE:
                return SignUpModel::getInstance();

            case Constants::IA_ORDER_ITEM_POST_TYPE:
                return OrderItemModel::getInstance();

            case Constants::IA_ENTRY_POST_TYPE:
            case Constants::IA_GENERIC_ENTRY_POST_TYPE:
                if (TemplateTypes::isCustomPostType($theTemplateId)) {
                    return CustomPostTypeModel::getInstance();
                } else if (TemplateTypes::isTaxonomy($theTemplateId)) {
                    return TaxonomyModel::getInstance();
                } else if (TemplateTypes::isSignUpType($theTemplateId)) {
                    return SignUpModel::getInstance();
                } else if (TemplateTypes::isOrderType($theTemplateId)) {
                    return OrderModel::getInstance();
                } else if (TemplateTypes::isSessionType($theTemplateId)) {
                    return GenericSessionModel::getInstance();
                } else {
                    return GenericEntryModel::getInstance();
                }


            case Constants::IA_POST_CONFIG_POST_TYPE:
            case Constants::IA_GENERIC_MODEL_POST_TYPE:
                if ($formConfigId != 0) {
                    $parentTplId = TemplateTypes::getParentTypeId($theTemplateId);
                    
                    if ($parentTplId == TemplateTypes::FT_MODEL_GROUP) {
                        return ChoiceGroupModel::getInstance();
                    } else {
                        return PostConfigModel::getInstance();
                    }
                }
                break;

            default:                
                break;
        }

        return null;
    }
}
