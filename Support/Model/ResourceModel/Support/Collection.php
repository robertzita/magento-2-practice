<?php

namespace Iweb\Support\Model\ResourceModel\Support;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'iweb_support_collection';
    protected $_eventObject = 'support_collection';
    
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\Support::class, \Iweb\Support\Model\ResourceModel\Support::class);
    }
    
}
