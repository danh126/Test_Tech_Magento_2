<?php

namespace Magenest\DeliveryTime\Block\Adminhtml\Order\View\Items;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;

class DeliveryTime extends Template
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getDeliveryTime(\Magento\Sales\Model\Order\Item $item)
    {
        $data = $item->getData('delivery_time');
        return $data ? $data : 'N/A';
    }

    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    public function getOrderItems()
    {
        return $this->getOrder()->getAllItems();
    }
}
