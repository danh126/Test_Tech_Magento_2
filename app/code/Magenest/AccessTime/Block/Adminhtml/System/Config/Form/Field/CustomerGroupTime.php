<?php
namespace Magenest\AccessTime\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\Group\Collection as GroupCollection;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Element\Html\Select;

class CustomerGroupTime extends \Magento\Config\Block\System\Config\Form\Field
{
    protected $_customerGroup;

    public function __construct(
        Context $context,
        GroupCollection $customerGroup,
        array $data = []
    ) {
        $this->_customerGroup = $customerGroup;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $html = '<table>';
        $html .= '<tr><th>Customer Group</th><th>Access Time (days)</th></tr>';

        $value = json_decode($element->getValue(), true) ?? [];

        foreach ($this->_customerGroup->toOptionArray() as $group) {
            if ($group['value'] == 0) continue; // skip NOT LOGGED IN

            $groupId = $group['value'];
            $days = $value[$groupId] ?? '';

            $html .= '<tr>';
            $html .= '<td>' . $group['label'] . '</td>';
            $html .= '<td><input type="text" name="' . $element->getName() . '[' . $groupId . ']" value="' . $days . '" /></td>';
            $html .= '</tr>';
        }

        $html .= '</table>';
        return $html;
    }
}
