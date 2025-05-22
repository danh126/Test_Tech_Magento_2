<?php
namespace Magenest\AccessTime\Model;

use Magento\Framework\Model\AbstractModel;

class AccessTime extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magenest\AccessTime\Model\ResourceModel\AccessTime::class);
    }
}
