<?php
namespace Magenest\OfferPopup\Model;

use Magento\Framework\Model\AbstractModel;

class Offer extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magenest\OfferPopup\Model\ResourceModel\Offer::class);
    }
}
