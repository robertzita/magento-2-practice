<?php

namespace Iweb\Support\Model\ResourceModel\Reply;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\Reply::class, \Iweb\Support\Model\ResourceModel\Reply::class);
    }
}
