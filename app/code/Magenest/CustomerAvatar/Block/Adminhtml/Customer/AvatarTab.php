<?php
namespace Magenest\CustomerAvatar\Block\Adminhtml\Customer;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class AvatarTab extends Template implements TabInterface
{
    protected $_coreRegistry;

    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
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
            return $this->getUrl('pub/media/' . $customer->getAvatar());
        }
        return false;
    }

    // TabInterface methods:
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
