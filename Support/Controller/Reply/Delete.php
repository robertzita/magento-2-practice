<?php

namespace Iweb\Support\Controller\Reply;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $replyFactory;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $replyFactory
    ) {
        $this->replyFactory = $replyFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $replyId = $this->getRequest()->getParam('reply_id');
        $reply = $this->replyFactory->create()->load($replyId);
        $supportId = $reply->getSupportId();
        $reply->delete();
        
        return $this->_redirect('support/reply/allreplies', ['id' => $supportId]);
    }
}
