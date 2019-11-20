<?php

namespace Iweb\Note\Observer;

class SalesOrderSaveDeliveryNote implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
       $deliveryNote = $observer->getQuote()->getDeliveryNote();
       
       $observer->getOrder()->setDeliveryNote($deliveryNote);
    }
}
