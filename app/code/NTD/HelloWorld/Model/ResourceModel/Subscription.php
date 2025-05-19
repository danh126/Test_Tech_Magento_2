<?php
namespace NTD\HelloWorld\Model\ResourceModel;
class Subscription extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
        $this->_init('ntd_helloworld_subscription', 'subscription_id');
    }
}
