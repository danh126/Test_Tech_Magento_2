<?php

namespace Magenest\Movies\Model\Config\Tab;

use Magento\Framework\Data\OptionSourceInterface;

class Magenest implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [['value' => 'magenest', 'label' => __('Magenest')]];
    }
}
