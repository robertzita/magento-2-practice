<?php

namespace Iweb\Support\Ui\Component\Listing\Support\Column;

class LastReply extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $replyCollectionFactory;
    protected $userFactory;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        array $components = [],
        array $data = []        
    ) {
        $this->replyCollectionFactory = $replyCollectionFactory;
        $this->userFactory = $userFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $row) {
                $reply = $this->replyCollectionFactory->create()->addFieldToFilter('support_id', $row['id']);
                $lastReply = $reply->getLastItem();
                $adminId = $lastReply->getAdminId();
                
                if($adminId) {
                    $row[$this->getData('name')] = $this->userFactory->create()->load($adminId)->getUserName();
                } else {
                    $row[$this->getData('name')] = $row['customer_id'];
                }
            }
        }

        return $dataSource;
    }
}
