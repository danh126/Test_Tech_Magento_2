<?php
namespace Magenest\B2BBanner\Block;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;

class Banner extends Template
{
    protected $customerSession;

    public function __construct(
        Template\Context $context,
        CustomerSession $customerSession,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function isB2B()
    {
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }

        $customer = $this->customerSession->getCustomer();
        $attr = $customer->getCustomAttribute('is_b2b');
        return $attr && $attr->getValue() == 1;
    }
}
