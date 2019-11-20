<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class Delete extends \Magento\Backend\App\Action
{
    protected $replyFactory;
    
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Iweb\Support\Model\ReplyFactory $replyFactory
    ) {
        $this->replyFactory = $replyFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $reply = $this->replyFactory->create()->load($this->getRequest()->getParam('reply_id'));
        $supportId = $reply->getSupportId();
        $reply->delete();
        
        return $this->_redirect('support/supportpage/reply', ['support_id' => $supportId]);        
    }
}
