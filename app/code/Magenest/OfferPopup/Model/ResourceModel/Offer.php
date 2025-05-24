<?php
namespace Magenest\OfferPopup\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Offer extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_offer_popup', 'offer_id');
    }
}
