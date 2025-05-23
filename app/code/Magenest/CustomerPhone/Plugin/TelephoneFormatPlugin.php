<?php
namespace Magenest\CustomerPhone\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;

class TelephoneFormatPlugin
{
    public function beforeSave(\Magento\Customer\Api\CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {
        $telephone = $customer->getCustomAttribute('telephone') ? $customer->getCustomAttribute('telephone')->getValue() : null;
        if ($telephone) {
            // Nếu bắt đầu bằng +84 thì đổi thành 0
            if (str_starts_with($telephone, '+84')) {
                $telephone = '0' . substr($telephone, 3);
            }
            // Giới hạn độ dài tối đa 10 ký tự
            $telephone = substr($telephone, 0, 10);

            $customer->setCustomAttribute('telephone', $telephone);
        }
        return [$customer];
    }
}
