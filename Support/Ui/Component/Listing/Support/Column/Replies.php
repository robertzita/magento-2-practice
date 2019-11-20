<?php

namespace Iweb\Support\Ui\Component\Listing\Support\Column;

class Replies extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $replyCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory,
        array $components = [],
        array $data = []        
    ) {
        $this->replyCollectionFactory = $replyCollectionFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
        
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $row) {
                $noOfReplies = $this->replyCollectionFactory->create()->addFieldToFilter('support_id', $row['id'])->getSize();
                $row[$this->getData('name')] = $noOfReplies;
            }
        }
        
        return $dataSource;
    }
}
