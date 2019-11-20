<?php

namespace Iweb\Support\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ADMIN_REPLY_NOTIFICATION_ENABLED        = 'support_reply/admin_reply_notification/enabled';
    const XML_PATH_ADMIN_REPLY_NOTIFICATION_EMAIL_IDENTITY = 'support_reply/admin_reply_notification/email_identity';
    const XML_PATH_ADMIN_REPLY_NOTIFICATION_EMAIL_TEMPLATE = 'support_reply/admin_reply_notification/email_template';
    const XML_PATH_ADMIN_EDIT_NOTIFICATION_ENABLED         = 'support_reply/admin_edit_notification/enabled';
    const XML_PATH_ADMIN_EDIT_NOTIFICATION_EMAIL_IDENTITY  = 'support_reply/admin_edit_notification/email_identity';
    const XML_PATH_ADMIN_EDIT_NOTIFICATION_EMAIL_TEMPLATE  = 'support_reply/admin_edit_notification/email_template';
    const XML_PATH_CUSTOMER_NEW_TICKET_NOTIFICATION_ENABLED         = 'support_reply/customer_new_ticket_notification/enabled';
    const XML_PATH_CUSTOMER_NEW_TICKET_NOTIFICATION_EMAIL_IDENTITY  = 'support_reply/customer_new_ticket_notification/email_identity';
    const XML_PATH_CUSTOMER_NEW_TICKET_NOTIFICATION_EMAIL_TEMPLATE  = 'support_reply/customer_new_ticket_notification/email_template';
    const XML_PATH_CUSTOMER_REPLY_NOTIFICATION_ENABLED         = 'support_reply/customer_reply_notification/enabled';
    const XML_PATH_CUSTOMER_REPLY_NOTIFICATION_RECIPIENT_EMAIL = 'support_reply/customer_reply_notification/recipient_email';
    const XML_PATH_CUSTOMER_REPLY_NOTIFICATION_EMAIL_IDENTITY  = 'support_reply/customer_reply_notification/email_identity';
    const XML_PATH_CUSTOMER_REPLY_NOTIFICATION_EMAIL_TEMPLATE  = 'support_reply/customer_reply_notification/email_template';
    
    protected $inlineTranslation;
    protected $transportBuilder;
    protected $storeManager;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager    
    ) {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        
        parent::__construct($context);
    }
    
    //admin reply email notification
    public function isAdminReplyNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ADMIN_REPLY_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getAdminReplyNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ADMIN_REPLY_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getAdminReplyNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ADMIN_REPLY_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendAdminReplyNotificationEmail($customerName, $admin, $supportTitle, $comment, $customerEmail)
    {
        if ($this->isAdminReplyNotificationEnabled()) {
                $emailTemplate = $this->getAdminReplyNotificationEmailTemplate();
                $emailSender   = $this->getAdminReplyNotificationEmailIdentity();

                $this->inlineTranslation->suspend();

                $this->transportBuilder
                    ->setTemplateIdentifier($emailTemplate)
                    ->setTemplateOptions([
                        'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId()
                    ])
                    ->setTemplateVars([
                        'customer_name' => $customerName,
                        'admin_name'    => $admin,
                        'support_title' => $supportTitle,
                        'comment'       => $comment
                    ])
                    ->setFrom($emailSender)
                    ->addTo($customerEmail);

                $transport = $this->transportBuilder->getTransport();
                $transport->sendMessage();

                $this->inlineTranslation->resume();
            }
    }
    
    //admin edit email notification
    public function isAdminEditNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ADMIN_EDIT_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getAdminEditNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ADMIN_EDIT_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getAdminEditNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ADMIN_EDIT_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendAdminEditNotificiationEmail($customerName, $admin, $oldComment, $newComment, $customerEmail)
    {
        if($this->isAdminEditNotificationEnabled()) {
            $emailTemplate = $this->getAdminEditNotificationEmailTemplate();
            $emailSender = $this->getAdminEditNotificationEmailIdentity();

            $this->inlineTranslation->suspend();

            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId()
                ])
                ->setTemplateVars([
                    'customer_name' => $customerName,
                    'admin_name'    => $admin,
                    'old_comment'   => $oldComment,
                    'new_comment'   => $newComment
                ])    
                ->setFrom($emailSender)
                ->addTo($customerEmail);

            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();

            $this->inlineTranslation->resume();
        }
    }
    
    //customer new ticket notification
    public function isCustomerNewTicketNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CUSTOMER_NEW_TICKET_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerNewTicketNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_NEW_TICKET_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerNewTicketNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_NEW_TICKET_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendCustomerNewTicketNotificiationEmail($customerName, $supportTitle, $customerEmail)
    {
        if($this->isCustomerNewTicketNotificationEnabled()) {
            $emailTemplate = $this->getCustomerNewTicketNotificationEmailTemplate();
            $emailSender = $this->getCustomerNewTicketNotificationEmailIdentity();

            $this->inlineTranslation->suspend();

            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId()
                ])
                ->setTemplateVars([
                    'customer_name' => $customerName,
                    'support_title' => $supportTitle
                ])    
                ->setFrom($emailSender)
                ->addTo($customerEmail);

            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();

            $this->inlineTranslation->resume();
        }
    }
    
    //customer reply notification
    public function isCustomerReplyNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CUSTOMER_REPLY_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerReplyNotificationRecipientEmail()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_REPLY_NOTIFICATION_RECIPIENT_EMAIL,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerReplyNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_REPLY_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerReplyNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_REPLY_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendCustomerReplyNotificiationEmail($customerName, $supportTitle, $customerEmail, $comment)
    {
        if($this->isCustomerNewTicketNotificationEnabled()) {
            $emailTemplate = $this->getCustomerReplyNotificationEmailTemplate();
            $emailSender = $this->getCustomerReplyNotificationEmailIdentity();
            $recipientEmail = $this->getCustomerReplyNotificationRecipientEmail();

            $this->inlineTranslation->suspend();

            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId()
                ])
                ->setTemplateVars([
                    'customer_name'  => $customerName,
                    'support_title'  => $supportTitle,
                    'customer_email' => $customerEmail,
                    'comment'        => $comment
                ])    
                ->setFrom($emailSender)
                ->addTo($recipientEmail);

            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();

            $this->inlineTranslation->resume();
        }
    }

}
