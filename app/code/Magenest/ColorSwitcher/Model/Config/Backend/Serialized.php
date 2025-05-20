<?php
namespace Magenest\ColorSwitcher\Model\Config\Backend;

use Magento\Framework\App\Config\Value;

class Serialized extends Value
{
    public function beforeSave()
    {
        $value = $this->getValue();

        if (is_array($value)) {
            $this->setValue(json_encode($value)); // Convert mảng thành JSON string trước khi lưu
        }

        return parent::beforeSave();
    }
}
