<?php

namespace Iweb\Support\Ui\Component\Listing\Support\Column;

class CustomerId extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $customerFactory;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $components = [],
        array $data = []        
    ) {
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
        
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $row) {
                $columnName = $this->getData('name');
                
                $customerId = $row[$columnName];
                $customer = $this->customerFactory->create()->load($customerId);

                $row[$columnName] = $customer->getFirstname() . ' ' . $customer->getLastname(); 
            }
        }

        return $dataSource;
    }
}
