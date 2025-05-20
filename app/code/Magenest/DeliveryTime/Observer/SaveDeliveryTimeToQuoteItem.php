<?php
namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveDeliveryTimeToQuoteItem implements ObserverInterface
{
    protected $request;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        $deliveryTimeOption = $this->request->getParam('delivery_time_option');
        $deliveryDate = $this->request->getParam('delivery_date');

        if ($deliveryTimeOption) {
            $deliveryInfo = ['option' => $deliveryTimeOption];
            if ($deliveryTimeOption == 'pick_date' && $deliveryDate) {
                $deliveryInfo['date'] = $deliveryDate;
            }
            // Lưu dưới dạng JSON hoặc serialize vào quote item custom option
            $quoteItem->setData('delivery_time', json_encode($deliveryInfo));
        }
    }
}
