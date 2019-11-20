<?php

namespace Iweb\Note\Block\Adminhtml\Order\View;

class DeliveryNote extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Helper\Admin $adminHelper,
        $data = array()
    ) {
        parent::__construct($context, $registry, $adminHelper, $data);
    }
    
    public function getDeliveryNote()
    {
        $deliveryNote = $this->getOrder()->getDeliveryNote();
        if(!empty($deliveryNote)) {
            return $deliveryNote;
        } else {
            return 'No additional delivery note.';
        }
    }
}
