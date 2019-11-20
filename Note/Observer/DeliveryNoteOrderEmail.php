<?php

namespace Iweb\Note\Observer;

class DeliveryNoteOrderEmail implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $transportObject = $observer->getData('transportObject');
        $deliveryNote = $transportObject->getData('order')->getDeliveryNote();
        
        $transportObject['delivery_note'] = $deliveryNote;
    }
}
