<?php

namespace Iweb\Support\Controller\Ticket;

class NewTicketPost extends \Magento\Framework\App\Action\Action
{
    protected $session;
    protected $supportFactory;
    protected $customerFactory;
    protected $helper;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $session,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Iweb\Support\Helper\Data $helper
    ) {
        $this->session = $session;
        $this->supportFactory = $supportFactory;
        $this->customerFactory = $customerFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }
     
    public function execute()
    {
        $customerId  = $this->session->getId();
        $title       = $this->getRequest()->getParam('title');
        $description = $this->getRequest()->getParam('description');
        
        $this->supportFactory->create()
            ->setCustomerId($customerId)
            ->setTitle($title)
            ->setDescription($description)
            ->setSolved('no')
            ->save();
        
        $customer = $this->customerFactory->create()->load($customerId);
        $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
        $customerEmail = $customer->getEmail();
        
        $this->helper->sendCustomerNewTicketNotificiationEmail($customerName, $title, $customerEmail);
               
        $this->_redirect('support/ticket/alltickets');
     }
}
