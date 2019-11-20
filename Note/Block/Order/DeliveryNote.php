<?php

namespace Iweb\Note\Block\Order;

class DeliveryNote extends \Magento\Framework\View\Element\Template
{
    protected $coreRegistry = null;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    
    public function getDeliveryNote()
    {
        return $this->coreRegistry->registry('current_order')->getDeliveryNote();
    }
}
