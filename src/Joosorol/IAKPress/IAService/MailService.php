<?php

/*
 * This file is part of the IACAFactory package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAService;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\WP\IAModel\FieldConfigModel;
use App\Joosorol\WP\IAModel\PostConfigModel;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Action\ActionMailNotificationType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\ApiConfig\SmtpApiConfigType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\FieldRenderType;
use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\IATemplate\TemplateTypes;
use App\Joosorol\IAKPress\IAPost\PluginInterface;
use App\Joosorol\IAKPress\IAPost\PostConfig;
use App\Joosorol\WP\IAModel\ApiKeysModel;

class MailService
{
    /**
     * @var MailService The single instance of the class
     */
    private static $sInstance = null;


    /**
     * MailService Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main MailService Instance
     *
     * Ensures only one instance of MailService is loaded or can be loaded.
     *
     * @static
     * @return MailService - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function getPostConfig($formConfigId) {
        $formConfig =  PostConfigModel::getInstance()->getById($formConfigId);

        if (!is_null($formConfig)) {
            $formConfig[PostConfig::FIELDS] = FieldConfigModel::getInstance()->getListByName($formConfigId);
        }

        return $formConfig;
    }
      
    public function handleFormActions($formConfigId, $oldEntryId, array $entry, $submitBtnType, $submitBtnName) {
        $formConfig = $this->getPostConfig($formConfigId);

        if (is_null($formConfig)) {
            return array();
        }

        $actions = FieldConfigModel::getInstance()->fetchMailNotifActions($formConfigId);


        $mailNotifErrors = array();
        foreach ($actions as $action) {
            $err = $this->handleMailNotif($formConfig, $action, $oldEntryId, $entry);
            if (!empty($err)) {
                $mailNotifErrors[] = $err;
            }
        }

        $result =  [
            Constants::ID => $entry[Constants::ID],
            Constants::SUBMIT_BTN_TYPE => $submitBtnType,
            Constants::SUBMIT_BTN_NAME => $submitBtnName,
            Constants::MAIL_NOTIF_ERRORS => $mailNotifErrors,
            Constants::FRONT_ACTIONS => FieldConfigModel::getInstance()->fetchFrontActions($formConfigId)
        ];

        return $result;
    }


    public function handleMailNotif(array $formConfig, array $action,  $oldEntryId, array $entry) : string {
        $ccFieldName = $action[ActionMailNotificationType::CC] ?? '';

        $to = $action[ActionMailNotificationType::TO] ?? '';
        if (empty($to)) {
            $to =  get_option('admin_email');
        }
       
        $cc = $entry[$ccFieldName] ?? '';

        $messageTpl = $action[Option::MSG_BODY] ?? '';
        if (empty($messageTpl)) {
            $messageTpl = '{{ default_message }}';
        }
       
        $params = ApiKeysModel::getApiParamsByType(TemplateTypes::FT_SMTP_API);

        // Recipients
        $from_addr = $action[ActionMailNotificationType::FROM_ADDRESS] ?? '';

        $from_label = $action[ActionMailNotificationType::FROM_LABEL] ?? '';
        if (empty($from_label)) {
            $from_label = get_bloginfo( 'name' );
        }
    
        $content = $this->getMessageBody($formConfig, $entry, nl2br($messageTpl));
        

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 2;  // Debug Level 2

        var_dump($params);
        try {
            // Server Settings
            if (!empty($params)) { // use SMTP API to send the message
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $params[SmtpApiConfigType::HOST] ?? '';  
                $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
                $mail->Username   = $params[SmtpApiConfigType::USERNAME] ?? ''; 
                $mail->Password   = $params[SmtpApiConfigType::PASSWORD] ?? '';
                $mail->Port       = $params[SmtpApiConfigType::PORT] ?? '25';

            } else {
                $mail->isMail();  // Send using Php Mail
            }

            if (empty($from_addr)) {
                $adminEmail = get_option('admin_email');
                $mail->setFrom($adminEmail, $from_label, false);
            } else {
                $mail->setFrom($from_addr, $from_label, false);
            }

            $mail->addAddress($to);

            if (!empty($cc)) {
                $mail->addCC($cc);
            }

            $mail->Subject =  $action[ActionMailNotificationType::SUBJECT] ?? "";

            $mail->msgHTML($content);

            echo "_____________CONTENT__MAIL";
            var_dump($content);

            $mail->send();

            return "";
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    protected function getMessageBody(array $formConfig, array $entry, $bodyTpl) {
        $fields = $formConfig[PostConfig::FIELDS] ?? array();

        foreach($entry as $fieldName => $fieldVal) {
            $field = $fields[$fieldName] ?? null;
            if ($field != null) {
                $fieldType = intval($field[Option::FIELD_TYPE]);
                $parentType = FieldRenderType::getParentTypeId($fieldType);
                // get select field values labels
                if ($parentType == FieldRenderType::SELECT_CHOICE_TYPE || $parentType == FieldRenderType::SELECT_QUESTION_TYPE) {
                    $modelId = $field[Option::MODEL_ID] ?? '0';
                    if ($modelId != 0) {
                        $model = FieldConfigModel::getInstance()->getDatalist($fields, $field);
                        if (!empty($model)) {
                            $entries = $model[Constants::ENTRIES] ?? array();
                            $fieldValTab = explode(",", $fieldVal);
                            if (is_array($fieldValTab)) {
                                $newFieldVal = [];
                                foreach($fieldValTab as $entryId) {
                                    $optEntry = $entries[$entryId] ?? null;
                                    if ($optEntry) {
                                        $optTitle = $optEntry[Option::TITLE] ?? $entryId;
                                        $newFieldVal[] =   $optTitle;
                                    }
                                }

                                $entry[$fieldName] = implode(" | ", $newFieldVal);
                            }
                        }
                    }
                } else if ($fieldType == FieldRenderType::MEDIA_UPLOAD_FILE_TYPE || $fieldType == FieldRenderType::MEDIA_UPLOAD_IMAGE_TYPE) {
                    $uri = $entry[$fieldName];
                    $entry[$fieldName] =  PluginInterface::getInstance()->getTwig()->render('media-link.html.twig',  [
                        'uri' => $uri,
                        'title' => $uri,
                        'field' => $field
                    ]);
                }
            }
        }

        $params = array_merge(
            $entry,
            [
                'post_title' => $formConfig[PostConfig::POST_CONFIG_TITLE] ?? '',
                'fields' => $formConfig[PostConfig::FIELDS] ?? array(),
                'entry' => $entry
            ]
        );

        $default_message = PluginInterface::getInstance()->getTwig()->render('default_message.html.twig',  $params);

        $params['default_message'] =  $default_message;
        $params['body_tpl'] = $bodyTpl;

        $content = PluginInterface::getInstance()->getTwig()->render('mail-body.html.twig',  $params);

        return html_entity_decode($content);
    }
}
