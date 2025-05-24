<?php

namespace Magenest\CustomerAvatar\Block\Adminhtml\Customer;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class AvatarTab extends Template implements TabInterface
{
    protected $_coreRegistry;
    protected $_storeManager;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getCustomer()
    {
        return $this->_coreRegistry->registry('current_customer');
    }

    public function getAvatarUrl()
    {
        $customer = $this->getCustomer();
        if ($customer && $customer->getAvatar()) {
            return $this->_storeManager
                    ->getStore()
                    ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $customer->getAvatar();
        }
        return false;
    }

    // Các method của TabInterface:
    public function getTabLabel()
    {
        return __('Avatar');
    }

    public function getTabTitle()
    {
        return __('Avatar');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
