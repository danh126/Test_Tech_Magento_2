<?php
namespace NTD\HelloWorld\Model\ResourceModel\Subscription;
/**
 * Subscription Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct() {
        $this->_init('NTD\HelloWorld\Model\Subscription', 'NTD\HelloWorld\Model\ResourceModel\Subscription');
    }
}
