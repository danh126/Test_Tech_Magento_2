<?php
namespace Magenest\CourseProduct\Model\ResourceModel\Document;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Magenest\CourseProduct\Model\Document::class,
            \Magenest\CourseProduct\Model\ResourceModel\Document::class
        );
    }
}
