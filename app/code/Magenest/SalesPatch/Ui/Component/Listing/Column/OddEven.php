<?php

namespace Magenest\SalesPatch\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class OddEven extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $value = ($item['entity_id'] ?? 0) % 2 === 0 ? 'even' : 'odd';
                if ($value === 'odd') {
                    $item[$this->getData('name')] = '<span class="grid-severity-critical"><span>' . __('Odd') . '</span></span>';
                } else {
                    $item[$this->getData('name')] = '<span class="grid-severity-notice"><span>' . __('Even') . '</span></span>';
                }
            }
        }
        return $dataSource;
    }
}
