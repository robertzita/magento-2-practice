<?php

namespace Iweb\Note\Plugin\Adminhtml;

class AdminDeliveryNotePlugin 
{
   public function afterToHtml(\Magento\Sales\Block\Adminhtml\Order\View\Items $subject, $result)
   {
       $deliveryNote = $subject->getLayout()->getBlock('delivery_note')->toHtml();
       
       return $result .= $deliveryNote;
   }
}
