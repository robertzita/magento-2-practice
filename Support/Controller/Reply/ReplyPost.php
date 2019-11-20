<?php

namespace Iweb\Support\Controller\Reply;

class ReplyPost extends \Magento\Framework\App\Action\Action
{
    protected $replyFactory;
    protected $supportFactory;
    protected $customerFactory;
    protected $helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Iweb\Support\Helper\Data $helper
    ) {
        $this->replyFactory = $replyFactory;
        $this->supportFactory = $supportFactory;
        $this->customerFactory = $customerFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }
     
    public function execute()
    {
        $replyId = $this->getRequest()->getParam('reply_id');
        $supportId  = $this->getRequest()->getParam('support_id');
        $comment = $this->getRequest()->getParam('comment');
        $this->replyFactory->create()->load($replyId)
            ->setSupportId($supportId)
            ->setComment($comment)
            ->setVisible('yes')
            ->save();
        
        $support = $this->supportFactory->create()->load($supportId);
        $supportTitle = $support->getTitle();
        
        $customerId = $support->getCustomerId();
        $customer = $this->customerFactory->create()->load($customerId);
        $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
        $customerEmail = $customer->getEmail();
        
        if(empty($replyId)) {
            $this->helper->sendCustomerReplyNotificiationEmail($customerName, $supportTitle, $customerEmail, $comment);
        }
        
        $this->_redirect('support/reply/allreplies', ['id' => $supportId]);
    }
}
