<?php

namespace Iweb\Support\Block\Reply;

class ReplyEdit extends \Magento\Framework\View\Element\Template
{
    protected $request;
    protected $replyFactory;


    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->request = $request;
        $this->replyFactory = $replyFactory;
        parent::__construct($context);
    }
    
    public function getReplyId()
    {
        return $this->request->getParam('reply_id');
    }
    
    public function getReplyData($id)
    {
        $data = $this->replyFactory->create()->load($id);
        
        return $data;
    }
    
    public function getBackUrl($supportId)
    {
        return $this->_urlBuilder->getUrl('support/reply/allreplies', ['id' => $supportId]);
    }
    
    public function getPostActionUrl()
    {
        return $this->_urlBuilder->getUrl('support/reply/replypost');
    }
}
