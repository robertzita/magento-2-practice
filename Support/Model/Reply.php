<?php

namespace Iweb\Support\Model;

class Reply extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\ResourceModel\Reply::class);
    }
}
