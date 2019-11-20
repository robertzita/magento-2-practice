<?php

namespace Iweb\Support\Ui\Component\Listing\Reply\Column;

class AdminId extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $userFactory;
    protected $supportFactory;
    protected $customerFactory;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $components = [],
        array $data = []        
    ) {
        $this->userFactory = $userFactory;
        $this->supportFactory = $supportFactory;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
        
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$row) {
                $columnName = $this->getData('name');
                
                if ($row[$columnName]) { // Admin reply
                    $row[$columnName] = $this->userFactory->create()->load($row[$columnName])->getUsername();
                } else { // Customer reply
                    $supportId = $row['support_id'];
                    $support = $this->supportFactory->create()->load($supportId);
                    
                    $customerId = $support->getCustomerId();
                    $customer = $this->customerFactory->create()->load($customerId);
                    $row[$columnName] = $customer->getFirstname() . ' ' . $customer->getLastname();
                }
            }
        }

        return $dataSource;
    }
}
