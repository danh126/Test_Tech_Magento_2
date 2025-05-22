<?php
namespace Magenest\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Magenest\Blog\Model\Blog::class, \Magenest\Blog\Model\ResourceModel\Blog::class);
    }
}
