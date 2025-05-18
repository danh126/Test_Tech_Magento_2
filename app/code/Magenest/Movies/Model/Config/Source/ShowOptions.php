<?php

namespace Magenest\Movies\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ShowOptions implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('show')],
            ['value' => '2', 'label' => __('not-show')],
        ];
    }
}
