<?php

namespace Iweb\Support\Block\Ticket;

class TicketData extends \Magento\Framework\View\Element\Template
{
    protected $supportFactory;
    protected $session;
    protected $replyCollectionFactory;
    protected $userFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Customer\Model\Session $session,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory,
        \Magento\User\Model\UserFactory $userFactory
    ) {
        $this->supportFactory = $supportFactory;
        $this->session = $session;
        $this->replyCollectionFactory = $replyCollectionFactory;
        $this->userFactory = $userFactory;
        parent::__construct($context);
    }
    
    public function getNewTicketUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/newticket');
    }
    
    public function getAllTicketsUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/alltickets');
    }
    
    public function getPostActionUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/newticketpost');
    }
    
    public function getTicketData($id)
    {
        return $this->supportFactory->create()
                ->getCollection()
                ->addFieldToFilter('customer_id', $id)
                ->setOrder('created_at', 'desc');
    }
    
    public function getCurrentId()
    {
        $customerId = $this->session->getId();
      
        return $customerId;
    }
    
    public function getBackUrl()
    {
        return $this->_urlBuilder->getUrl('support/supportpage/index');
    }
    
    public function NoOfReplies($id)
    {
        return $this->replyCollectionFactory->create()
                ->addFieldToFilter('support_id', $id)
                ->getSize();
    }

    public function NoOfVisibleReplies($id)
    {
        return $this->replyCollectionFactory->create()
                ->addFieldToFilter('support_id', $id)
                ->addFieldToFilter('visible', 'yes')
                ->getSize();
    }
    
    public function lastRepliedBy($id)
    {
        $reply = $this->replyCollectionFactory->create()
            ->addFieldToFilter('support_id', $id)
            ->addFieldToFilter('visible', 'yes');
        
        $lastReply = $reply->getLastItem();
        
        $adminId = $lastReply->getAdminId();
        
        if($adminId) {
            return $this->userFactory->create()->load($adminId)->getUserName();
        } else {
            return 'Me';
        }
    }
}
