<?php

namespace Magenest\VnRegion\Plugin\Checkout;

class LayoutProcessorPlugin
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        $customField = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
            ],
            'dataScope' => 'shippingAddress.vn_region',
            'label' => __('Miền'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 250,
            'id' => 'vn_region',
            'options' => [
                ['value' => '1', 'label' => __('Miền Bắc')],
                ['value' => '2', 'label' => __('Miền Trung')],
                ['value' => '3', 'label' => __('Miền Nam')],
            ],
            'value' => '', // auto bind từ customer address
        ];

        // Inject vào shipping address fieldset
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['vn_region'] = $customField;

        // Inject vào billing address fieldset (cho phương thức thanh toán "checkmo" làm mẫu)
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['payments-list']['children']['checkmo-form']['children']
        ['form-fields']['children']['vn_region'] = $customField;

        return $jsLayout;
    }
}
