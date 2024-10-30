<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IALabel\FieldLabels;
use App\Joosorol\IAKPress\IAPost\IATemplate\Templates;
use App\Joosorol\IAKPress\IAModel\EntryModelMgr;
use App\Joosorol\IAKPress\IAPost\IAPostType\ChoiceGroupFieldPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\ChoiceGroupPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\ContactPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\GenericEntryPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\LicensePostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\PhotoGalleryPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\ProductVariantPostType;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use  App\Joosorol\IAKPress\IALabel\FrontLabels;
use App\Joosorol\IAKPress\IAPost\IAPostType\AdvancedStylePostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\GeneralStylePostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\IAKPostIdForm;
use App\Joosorol\IAKPress\IAPost\IAPostType\LinkedProductPostType;
use App\Joosorol\IAKPress\IAPost\IAPostType\StepsStylePostType;

class ClientConfig
{
    const FIELD_TYPES = 'field_types';
    const BLOCK_TYPES = 'block_types';
    const CURRENT_USER = 'current_user';
    const ROLES = 'roles';
    const ADMINFORMS = 'adminforms';
    const POST_CONFIG_CONFIG_SECTIONS = 'iapostsections';
    const PAGES = 'pages';

    const POST_TEMPLATES = 'post_templates';

    const LABELS = 'labels';
    const API_LIST = 'api_list';

    const HAS_BLOCKS = 'has_blocks';

    const COLORS = 'colors';

    const API_KEYS_TAB = [
        array(Option::TITLE => 'Mail SMTP', Option::TYPE => TemplateTypes::FT_SMTP_API),
        array(Option::TITLE => 'PayPal', Option::TYPE => TemplateTypes::FT_PAYPAL_API),
        array(Option::TITLE => 'Stripe', Option::TYPE => TemplateTypes::FT_STRIPE_API)
    ];


    /**
     * @var The single instance of the class
     */
    private static $sInstance = null;

    /**
     * @var array
     */
    private $adminConfig;

    /**
     * @var array
     */
    private $frontConfig;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var PostConfig
     */
    private $formConfig;



    /**
     * ClientConfig Constructor.
     */
    private function __construct()
    {
        $this->formConfig = new PostConfig();


        $this->roles = self::doGetRoles();

        $postGeneralStylePostType = new GeneralStylePostType();

        $apiKeysModel = EntryModelMgr::getInstance()->apiKeysModel();

        $locale = $this->getLocale();
        $dateLocale = str_replace("_", "-", $locale);

        $currentUser = PostUtils::getInstance()->getCurrentUser();

        $signupFormId = PostUtils::getInstance()->getOption(Constants::IAKPRESS_SIGN_UP_FORM_ID, 0);
        $sessionFormId = PostUtils::getInstance()->getOption(Constants::IAKPRESS_SESSION_FORM_ID, 0);
        $orderFormId = PostUtils::getInstance()->getOption(Constants::IAKPRESS_ORDER_FORM_ID, 0);

        $this->adminConfig = array_merge(
            PluginInterface::getInstance()->getAttrs(),

            [
                Constants::IS_PRO_VERSION => PluginInterface::getInstance()->getIsProVersionStr(),
                Constants::IS_WP => true,

                Constants::IAKPRESS_SIGN_UP_FORM_ID => $signupFormId,
                Constants::IAKPRESS_SESSION_FORM_ID => $sessionFormId,
                Constants::IAKPRESS_ORDER_FORM_ID => $orderFormId,

                self::CURRENT_USER => $currentUser ? $currentUser->toArray() : array(),
                self::ROLES => $this->roles,
                self::PAGES => PostUtils::getInstance()->getPages(),
                self::API_LIST =>  $apiKeysModel != null ? $apiKeysModel->fetchList(0) : array(),
                self::HAS_BLOCKS =>  PluginInterface::getInstance()->hasBlocks(),
                PostConfig::NAME => $this->formConfig->toArray(),

                GeneralStylePostType::NAME => $postGeneralStylePostType->toArray(),
                AdvancedStylePostType::NAME => (new AdvancedStylePostType())->toArray(),
                StepsStylePostType::NAME => (new StepsStylePostType())->toArray(),


                LicensePostType::NAME => (new LicensePostType())->toArray(),
                ContactPostType::NAME => (new ContactPostType())->toArray(),


                self::ADMINFORMS => [
                    GenericEntryPostType::NAME => (new GenericEntryPostType())->toArray(),
                    ChoiceGroupPostType::NAME => (new ChoiceGroupPostType())->toArray(),
                    ChoiceGroupFieldPostType::NAME => (new ChoiceGroupFieldPostType())->toArray(),
                    IAKPostIdForm::NAME => (new IAKPostIdForm())->toArray(),
                    PhotoGalleryPostType::NAME => (new PhotoGalleryPostType())->toArray(),
                    LinkedProductPostType::NAME => (new LinkedProductPostType())->toArray(),
                    ProductVariantPostType::NAME => (new ProductVariantPostType())->toArray()
                ],

                self::POST_CONFIG_CONFIG_SECTIONS => [
                    PostConfig::NAME => PostConfig::LABEL,
                    GeneralStylePostType::NAME => $postGeneralStylePostType->getLabel(),
                    AdvancedStylePostType::NAME => FieldLabels::translate(Option::ADVANCED_STYLE),
                    StepsStylePostType::NAME => FieldLabels::translate(Option::STEPS_STYLE)
                ],

                self::POST_TEMPLATES => (new Templates())->toArray(),
               
                self::FIELD_TYPES => FieldTypes::getInstance()->getFieldTypes(),

                self::BLOCK_TYPES => FieldTypes::getInstance()->getBlockTypes(),


                Constants::LOCALE => $locale,
                Constants::DATE_LOCALE => $dateLocale,
                Constants::USER_CAN_MANAGE => PluginInterface::getInstance()->getUserCanManage(),
                self::LABELS => FrontLabels::getInstance()->getLabels(),
                self::COLORS => self::getColorPalette(),
                Constants::IAK_TINYMCE_PLUGIN_URL => PluginInterface::getInstance()->getIAKTinymcePluginUrl()
            ]
        );

        $this->frontConfig = array_merge(
            PluginInterface::getInstance()->getAttrs(),
            [
                Constants::IS_PRO_VERSION => PluginInterface::getInstance()->getIsProVersionStr(),
                Constants::IAKPRESS_SIGN_UP_FORM_ID => $signupFormId,
                Constants::IAKPRESS_SESSION_FORM_ID => $sessionFormId,
                Constants::IAKPRESS_ORDER_FORM_ID => $orderFormId,
                self::CURRENT_USER => $currentUser ? $currentUser->toArray() : array(),
                self::ROLES => $this->roles,
                self::HAS_BLOCKS =>  PluginInterface::getInstance()->hasBlocks(),
                self::BLOCK_TYPES => FieldTypes::getInstance()->getBlockTypes(),
                self::PAGES => PostUtils::getInstance()->getPages(),
                Constants::LOCALE => $locale,
                Constants::DATE_LOCALE => $dateLocale,
                Constants::USER_CAN_MANAGE => PluginInterface::getInstance()->getUserCanManage(),
                self::LABELS => FrontLabels::getInstance()->getLabels(),
                self::COLORS => self::getColorPalette()
            ]
        );
    }

    /**
     * Main ClientConfig Instance
     *
     * Ensures only one instance of ClientConfig is loaded or can be loaded.
     *
     * @static
     * @return ClientConfig - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    /**
     * return admin client adminConfig
     */
    public function getAdminConfig($configPostType): array
    {
        return array_merge(
            $this->adminConfig,
            [
                'post_type' => $configPostType
            ]
        );
    }


     /**
     * return front client Config
     */
    public function getFrontConfig($configPostType): array
    {
        if (PostUtils::getInstance()->getUserCanManage()) {
            return $this->getAdminConfig($configPostType);
        } else {
            return array_merge(
                $this->frontConfig,
                [
                    'post_type' => $configPostType
                ]
            );
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getFieldTypes()
    {
        return $this->fieldTypes;
    }


    /**
     * Wordpress User
     */
    public static function getCurrentUser()
    {
        return PostUtils::getInstance()->getCurrentUser();
    }

    public static function getLocale() {
        return PostUtils::getInstance()->getLocale();
    }

    public static function userLoggedIn()
    {
        return PostUtils::getInstance()->userLoggedIn();
    }

    public static function doGetRoles()
    {
        return PostUtils::getInstance()->doGetRoles();
    }

    public static function getColorPalette() : array {
        static $res;

        if (!$res) {
            $res = [
                [
					"name" => esc_attr__("Black"),
					"slug" => "black",
					"color" => "#000000"
                ],
                [
					"name" =>  esc_attr__("Cyan bluish gray"),
					"slug" => "cyan-bluish-gray",
					"color" => "#abb8c3"
                ],
                [
					"name" =>  esc_attr__("White"),
					"slug" => "white",
					"color" => "#ffffff"
                ],
                [
					"name" =>  esc_attr__("Pale pink"),
					"slug" => "pale-pink",
					"color" => "#f78da7"
                ],
                [
					"name" =>  esc_attr__("Vivid red"),
					"slug" => "vivid-red",
					"color" => "#cf2e2e"
                ],
                [
					"name" =>  esc_attr__("Luminous vivid orange"),
					"slug" => "luminous-vivid-orange",
					"color" => "#ff6900"
                ],
                [
					"name" =>  esc_attr__("Luminous vivid amber"),
					"slug" => "luminous-vivid-amber",
					"color" => "#fcb900"
                ],
                [
					"name" =>  esc_attr__("Light green cyan"),
					"slug" => "light-green-cyan",
					"color" => "#7bdcb5"
                ],
                [
					"name" =>  esc_attr__("Vivid green cyan"),
					"slug" => "vivid-green-cyan",
					"color" => "#00d084"
                ],
                [
					"name" =>  esc_attr__("Pale cyan blue"),
					"slug" => "pale-cyan-blue",
					"color" => "#8ed1fc"
                ],
                [
					"name" =>  esc_attr__("Vivid cyan blue"),
					"slug" => "vivid-cyan-blue",
					"color" => "#0693e3"
                ],
                [
					"name" =>  esc_attr__("Vivid purple"),
					"slug" => "vivid-purple",
					"color" => "#9b51e0"
                ]
            ];
        }

        return $res;
    }
}
