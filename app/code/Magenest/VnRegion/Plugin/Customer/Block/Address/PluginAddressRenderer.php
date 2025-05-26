<?php
namespace Magenest\VnRegion\Plugin\Customer\Block\Address;

use Magento\Customer\Block\Address\Renderer\RendererInterface;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Model\Config;

class PluginAddressRenderer
{
    protected $eavConfig;
    protected $addressMetadata;

    public function __construct(
        Config $eavConfig,
        AddressMetadataInterface $addressMetadata
    ) {
        $this->eavConfig = $eavConfig;
        $this->addressMetadata = $addressMetadata;
    }

    public function afterRender(RendererInterface $subject, $result,\Magento\Customer\Api\Data\AddressInterface $address
    ) {
        $vnRegionId = $address->getCustomAttribute('vn_region');
        if ($vnRegionId) {
            // Load label bằng source model
            $attribute = $this->eavConfig->getAttribute('customer_address', 'vn_region');
            $options = $attribute->getSource()->getAllOptions();
            $label = '';

            foreach ($options as $option) {
                if ($option['value'] == $vnRegionId->getValue()) {
                    $label = $option['label'];
                    break;
                }
            }

            if ($label) {
                // Thêm vào sau cùng dòng địa chỉ
                $result .= '<br/><strong>Miền:</strong> ' . $label;
            }
        }

        var_dump($result);
        die();

        return $result;
    }
}
