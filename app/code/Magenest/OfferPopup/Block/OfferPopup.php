<?php
namespace Magenest\OfferPopup\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;
use Magenest\OfferPopup\Model\ResourceModel\Offer\CollectionFactory as OfferCollectionFactory;

class OfferPopup extends Template
{
    protected $customerSession;
    protected $offerCollectionFactory;

    public function __construct(
        Template\Context $context,
        CustomerSession $customerSession,
        OfferCollectionFactory $offerCollectionFactory,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->offerCollectionFactory = $offerCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getOfferData()
    {
        $groupId = 0; // guest group id
        if ($this->customerSession->isLoggedIn()) {
            $groupId = $this->customerSession->getCustomerGroupId();
        }

        $collection = $this->offerCollectionFactory->create()
            ->addFieldToFilter('customer_group_id', $groupId)
            ->addFieldToFilter('is_active', 1)
            ->setPageSize(1);

        return $collection->getFirstItem();
    }
}
