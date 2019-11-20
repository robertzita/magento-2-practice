<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    protected $adminSession;
    protected $replyFactory;
    protected $supportFactory;
    protected $customerFactory;
    protected $userFactory;
    protected $helper;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Iweb\Support\Helper\Data $helper
    ) {
        $this->adminSession = $adminSession;
        $this->replyFactory = $replyFactory;
        $this->supportFactory = $supportFactory;
        $this->customerFactory = $customerFactory;
        $this->userFactory = $userFactory;
        $this->helper = $helper;
        
        parent::__construct($context);
    }
    
    public function execute()
    { 
        $replyId   = $this->getRequest()->getParam('id');
        $supportId = $this->getRequest()->getParam('support_id');
        $adminId   = $this->adminSession->getUser()->getId();
        $comment   = $this->getRequest()->getParam('comment');
                
        $reply = $this->replyFactory->create()->load($replyId);
        $reply->setSupportId($supportId)
            ->setAdminId($adminId)
            ->setComment($comment)
            ->setVisible('yes')
            ->save();
        
        $oldComment = $reply->getOrigData('comment');
        $newComment = $reply->getData('comment');
        
        //support info
        $support = $this->supportFactory->create()->load($supportId);
        $supportTitle = $support->getTitle();
        
        //customer info
        $customerId = $support->getCustomerId();
        $customer = $this->customerFactory->create()->load($customerId);
        $customerEmail = $customer->getEmail();
        $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
        
        //admin info
        $admin = $this->userFactory->create()->load($adminId)->getUsername();
        
        //send email
        if(empty($replyId)){
            $this->helper->sendAdminReplyNotificationEmail($customerName, $admin, $supportTitle, $comment, $customerEmail);
        } else {
            $this->helper->sendAdminEditNotificiationEmail($customerName, $admin, $oldComment, $newComment, $customerEmail);
        }
        
        return $this->_redirect('support/supportpage/reply', ['support_id' => $supportId]);
    }
}
