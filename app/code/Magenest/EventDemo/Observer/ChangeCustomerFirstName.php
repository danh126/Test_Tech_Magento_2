<?php

namespace Magenest\EventDemo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ChangeCustomerFirstName implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $customer = $observer->getCustomer();
        $customer->setFirstname('Magenest');
    }
}
