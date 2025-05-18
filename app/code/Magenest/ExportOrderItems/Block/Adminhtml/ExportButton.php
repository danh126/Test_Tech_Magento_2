<?php
namespace Magenest\ExportOrderItems\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

class ExportButton extends Template
{
    public function getExportUrl()
    {
        return $this->getUrl('magenest_export/export/orderitems');
    }
}
