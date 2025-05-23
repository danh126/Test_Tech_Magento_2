<?php
namespace Magenest\CourseProduct\Model;

use Magento\Framework\Model\AbstractModel;

class Document extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magenest\CourseProduct\Model\ResourceModel\Document::class);
    }
}
