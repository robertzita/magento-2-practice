<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class MassDelete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    protected $filter;
    protected $collectionFactory;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context);
    }
    
    public function execute()
    {
        $supportId = null;
        
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $reply) {
            if (!$supportId) {
                $supportId = $reply->getSupportId();
            }
            
            $reply->delete();
        }
        
        return $this->_redirect('support/supportpage/reply', ['support_id' => $supportId]);
    }
}
