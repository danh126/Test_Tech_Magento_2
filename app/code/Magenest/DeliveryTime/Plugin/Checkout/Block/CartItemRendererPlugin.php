<?php
namespace Magenest\DeliveryTime\Plugin\Checkout\Block;

class CartItemRendererPlugin
{
    public function afterGetProductOptions(\Magento\Checkout\Block\Cart\Item\Renderer $subject, $result)
    {
        $deliveryTime = $subject->getItem()->getData('delivery_time');
        if ($deliveryTime) {
            $deliveryInfo = json_decode($deliveryTime, true);
            if ($deliveryInfo) {
                if ($deliveryInfo['option'] == 'same_day') {
                    $text = 'Giao hàng trong ngày';
                } elseif ($deliveryInfo['option'] == 'pick_date' && !empty($deliveryInfo['date'])) {
                    $text = 'Ngày giao hàng: ' . $deliveryInfo['date'];
                } else {
                    $text = 'Thời gian giao hàng không xác định';
                }
                $result[] = [
                    'label' => 'Thời gian giao hàng',
                    'value' => $text
                ];
            }
        }
        return $result;
    }
}
