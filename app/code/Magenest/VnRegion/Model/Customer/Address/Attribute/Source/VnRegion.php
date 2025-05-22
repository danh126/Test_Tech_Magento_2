<?php
namespace Magenest\VnRegion\Model\Customer\Address\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class VnRegion extends AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Miền Bắc'), 'value' => 1],
                ['label' => __('Miền Trung'), 'value' => 2],
                ['label' => __('Miền Nam'), 'value' => 3],
            ];
        }
        return $this->_options;
    }
}
