<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class MassVisible extends \Magento\Backend\App\Action 
{
    protected $filter;
    protected $collectionFactorty;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $collectionFactory  
    ) {
        $this->filter = $filter;
        $this->collectionFactorty = $collectionFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $supportId = null;
        
        $visible = $this->getRequest()->getParam('visible');
        $collection = $this->filter->getCollection($this->collectionFactorty->create());
        foreach ($collection as $reply) {
            if(!$supportId) {
                $supportId = $reply->getSupportId();
            }
            
            $reply->setVisible($visible)
                ->save();
        }
        
        return $this->_redirect('support/supportpage/reply', ['support_id' => $supportId]);
    }
}
