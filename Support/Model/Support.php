<?php

namespace Iweb\Support\Model;

class Support extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\ResourceModel\Support::class);
    }
}
