<?php

namespace Iweb\Support\Model\ResourceModel;

class Support extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('iweb_support', 'id');
    }
}
