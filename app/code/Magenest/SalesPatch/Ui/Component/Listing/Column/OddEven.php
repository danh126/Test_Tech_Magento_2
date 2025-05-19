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
                $id = $item['entity_id'] ?? 0;
                $item[$this->getData('name')] = ($id % 2 === 0) ? 'Even' : 'Odd';
            }
        }
        return $dataSource;
    }
}
