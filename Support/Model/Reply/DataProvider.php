<?php

namespace Iweb\Support\Model\Reply;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    protected $collection;
    protected $request;
    protected $data;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory,
        \Magento\Framework\App\RequestInterface $request,
        array $meta = [],
        array $data = [],
        \Magento\Ui\DataProvider\Modifier\PoolInterface $pool = null
    ) {
        $this->collection = $replyCollectionFactory->create();
        $this->request = $request;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    public function getData()
    {
        $replies = $this->collection->getItems();
        foreach ($replies as $reply) {
            $this->data[$reply->getId()] = $reply->getData();
        }
        
        $newReply = $this->collection->getNewEmptyItem();
        $newReply->setData([ 'support_id' => $this->request->getParam('support_id') ]);
        
        $this->data[$newReply->getId()] = $newReply->getData(); // $reply->getId() is NULL because we're creating a new reply
        
        return $this->data;
    }
}
