<?php
namespace Magenest\AccessTime\Model\ResourceModel\AccessTime;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Magenest\AccessTime\Model\AccessTime::class,
            \Magenest\AccessTime\Model\ResourceModel\AccessTime::class
        );
    }
}
