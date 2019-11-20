<?php

namespace Iweb\Support\Controller\Adminhtml\Supportpage;

class MassSolved extends \Magento\Backend\App\Action 
{
    protected $filter;
    protected $collectionFactorty;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Iweb\Support\Model\ResourceModel\Support\CollectionFactory $collectionFactory  
    ) {
        $this->filter = $filter;
        $this->collectionFactorty = $collectionFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $solved = $this->getRequest()->getParam('solved');
        $collection = $this->filter->getCollection($this->collectionFactorty->create());
        foreach ($collection as $ticket) {
            $ticket->setSolved($solved)
                ->setUpdatedAt()
                ->save();
        }
        
        return $this->_redirect('support/supportpage/index');
    }
}
