<?php
namespace Magenest\HelloWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Hello extends Template implements BlockInterface
{
    protected $_template = "widget/hello.phtml";

    public function getName()
    {
        return $this->getData('name') ?: 'Khách';
    }
}
