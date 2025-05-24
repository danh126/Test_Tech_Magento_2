<?php
namespace Magenest\Banner\Model;

use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Banner::class);
    }
}
