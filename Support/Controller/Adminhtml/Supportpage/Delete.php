<?php

namespace Iweb\Support\Controller\Adminhtml\Supportpage;

class Delete extends \Magento\Backend\App\Action
{
    protected $SupportFactory;
    protected $replyCollectionFactory;

    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Iweb\Support\Model\SupportFactory $supportFactory,
       \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory
    ) {
        $this->supportFactory = $supportFactory;
        $this->replyCollectionFactory = $replyCollectionFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $supportId = $this->getRequest()->getParam('support_id');
        $this->supportFactory->create()
                ->load($supportId)
                ->delete();
        
        $collection = $this->replyCollectionFactory->create()->addFieldToFilter('support_id', $supportId);
        foreach ($collection as $reply) {
            $reply->delete();
        }
        
        return $this->_redirect('support/supportpage/index');        
    }
}
