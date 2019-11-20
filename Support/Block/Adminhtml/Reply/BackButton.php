<?php

namespace Iweb\Support\Block\Adminhtml\Reply;

class BackButton implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    
    protected $urlBuilder;
    protected $request;
    protected $replyFactory;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Iweb\Support\Model\ReplyFactory $replyFactory
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->replyFactory = $replyFactory;
    }
    
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    public function getBackUrl()
    {
        if($this->urlBuilder->getUrl('*/*/*') == $this->urlBuilder->getUrl('support/supportpage/reply')) {
            return $this->urlBuilder->getUrl('support/supportpage/index');
        } else {
            $replyId = $this->request->getParam('reply_id');
            $reply = $this->replyFactory->create()->load($replyId);
            
            return $this->urlBuilder->getUrl('support/supportpage/reply', ['support_id' => $reply->getSupportId()]);
        }
        
    }
}
