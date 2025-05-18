<?php

namespace Magenest\Movies\Ui\DataProvider\Movie;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            ['director_table' => $this->getTable('magenest_director')],
            'main_table.director_id = director_table.director_id',
            ['director_name' => 'name']
        );

        return $this;
    }
}
