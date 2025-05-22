<?php

namespace Magenest\ExportOrderItems\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

class ExportButton extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getExportUrl()
    {
        return $this->getUrl('magenest_export/order/exportcsv');
    }
}
