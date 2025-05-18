<?php

namespace Magenest\Movies\Model\ResourceModel\Movie;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'movie_id';

    protected function _construct()
    {
        $this->_init(
            \Magenest\Movie\Model\Movie::class,
            \Magenest\Movie\Model\ResourceModel\Movie::class
        );
    }
}
