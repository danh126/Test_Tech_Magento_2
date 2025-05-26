<?php

namespace Magenest\VnRegion\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveVnRegion implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $address = $observer->getEvent()->getCustomerAddress();

        if (!$address) {
            return;
        }

        // Dữ liệu từ form gửi lên (vn_region nằm trong POST)
        $request = $address->getData('custom_attributes');

        if (isset($request['vn_region'])) {
            $address->setData('vn_region', $request['vn_region']);
        }
    }
}
