<?php
namespace Magenest\B2BBanner\Block;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Banner extends Template
{
    protected $customerSession;
    protected $customerRepository;

    public function __construct(
        Template\Context $context,
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }

    public function isB2B()
    {
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }

        $customerId = $this->customerSession->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);

        $attr = $customer->getCustomAttribute('is_b2b');
        return $attr && $attr->getValue() == 1;
    }
}

