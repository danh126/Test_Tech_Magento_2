<?php
namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class CopyDeliveryTimeToOrder implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $quote = $observer->getQuote();
        $order = $observer->getOrder();

        foreach ($order->getAllItems() as $orderItem) {
            $quoteItem = $quote->getItemById($orderItem->getQuoteItemId());
            if ($quoteItem) {
                $deliveryTime = $quoteItem->getData('delivery_time');
                if ($deliveryTime) {
                    $orderItem->setData('delivery_time', $deliveryTime);
                }
            }
        }
    }
}
