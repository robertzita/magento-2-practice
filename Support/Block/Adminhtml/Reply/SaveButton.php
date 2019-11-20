<?php

namespace Iweb\Support\Block\Adminhtml\Reply;

class SaveButton implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    protected $urlBuilder;
    
    public function __construct(  
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
    }
    
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
        ];
    }
}
