<?php
namespace Magenest\AccessTime\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveAccessTimeObserver implements ObserverInterface
{
    protected $accessTimeResource;

    public function __construct(
        \Magenest\AccessTime\Model\ResourceModel\AccessTime $accessTimeResource
    ) {
        $this->accessTimeResource = $accessTimeResource;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();
        $accessTimeDataJson = $product->getData('access_time_data');
        if ($accessTimeDataJson) {
            $accessTimeData = json_decode($accessTimeDataJson, true);
            if (is_array($accessTimeData)) {
                $this->accessTimeResource->saveAccessTimeData($product->getId(), $accessTimeData);
            }
        }
    }
}
