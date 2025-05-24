<?php
namespace Magenest\OfferPopup\Model\ResourceModel\Offer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'offer_id';

    protected function _construct()
    {
        $this->_init(
            \Magenest\OfferPopup\Model\Offer::class,
            \Magenest\OfferPopup\Model\ResourceModel\Offer::class
        );
    }
}
