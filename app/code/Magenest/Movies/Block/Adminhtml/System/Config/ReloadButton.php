<?php

namespace Magenest\Movies\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ReloadButton extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $buttonLabel = __('Reload Page');
        return '<button onclick="location.reload();">' . $buttonLabel . '</button>';
    }
}
