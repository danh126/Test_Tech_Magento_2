<?php
namespace Magenest\DeliveryTime\Plugin;

use Magento\Quote\Model\Quote\Item;
use Magento\Sales\Model\Order\Item as OrderItem;

class QuoteToOrderItemPlugin
{
    public function afterConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        OrderItem $result,
        Item $quoteItem
    ) {
        $deliveryTime = $quoteItem->getData('delivery_time');
        if ($deliveryTime) {
            $result->setData('delivery_time', $deliveryTime);
        }
        return $result;
    }
}
