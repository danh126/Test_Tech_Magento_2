<?php
namespace Magenest\Banner\Model\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Banner\Model\Banner as BannerModel;
use Magenest\Banner\Model\ResourceModel\Banner as ResourceBanner;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BannerModel::class, ResourceBanner::class);
    }
}
