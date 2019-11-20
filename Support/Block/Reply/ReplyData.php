<?php

namespace Iweb\Support\Block\Reply;

class ReplyData extends \Magento\Framework\View\Element\Template
{
    protected $request;
    protected $replyFactory;
    
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->replyFactory = $replyFactory;
        $this->request = $request;
        parent::__construct($context);
    }
    
    public function getReplyData($id)
    {
        return $this->replyFactory->create()->getCollection()
                    ->addFieldToFilter('support_id', $id)
                    ->addFieldToFilter('visible', 'yes')
                    ->addOrder('created_at', 'desc');
    }
    
    public function getBackUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/alltickets');
    }
    
    public function getPostActionUrl()
    {
        return $this->_urlBuilder->getUrl('support/reply/replypost');
    }
    
    public function getCurrentId()
    {
        return $this->request->getParam('id');
    }
}
