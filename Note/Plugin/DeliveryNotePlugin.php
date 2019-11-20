<?php

namespace Iweb\Note\Plugin;

class DeliveryNotePlugin 
{
    protected $quoteRepository;
    
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Api\ShippingInformationManagementInterface $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        if ($extensionAttributes = $addressInformation->getShippingAddress()->getExtensionAttributes()) {
            $deliveryNote = $extensionAttributes->getDeliveryNote();
            
            $this->quoteRepository->getActive($cartId)
                ->setDeliveryNote($deliveryNote);
        }
        return null;        
    }    
}
