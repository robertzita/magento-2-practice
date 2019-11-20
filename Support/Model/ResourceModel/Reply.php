<?php

namespace Iweb\Support\Model\ResourceModel;

class Reply extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('iweb_support_reply', 'id');
    }
}
