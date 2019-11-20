<?php

namespace Iweb\Support\Model\ResourceModel\Support\Grid;

class Collection extends \Iweb\Support\Model\ResourceModel\Support\Collection implements \Magento\Framework\Api\Search\SearchResultInterface
{
    protected $aggregations;
    
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        
        $this->eventPrefix = $eventPrefix;
        $this->eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }
    
    public function getAggregations()
    {
        return $this->aggregations;
    }
    
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }
    
    public function getSearchCriteria()
    {
        return null;
    }
    
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
    
    public function getTotalCount()
    {
        return $this->getSize();
    }
    
    public function setTotalCount($totalCount)
    {
        return $this;
    }
    
    public function setItems(array $items = null)
    {
        return $this;
    }
}
