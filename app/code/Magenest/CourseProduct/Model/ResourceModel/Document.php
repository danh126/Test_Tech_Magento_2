<?php
namespace Magenest\CourseProduct\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Document extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_course_documents', 'document_id');
    }
}
