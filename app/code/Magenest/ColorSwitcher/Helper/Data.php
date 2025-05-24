<?php
namespace Magenest\ColorSwitcher\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const CONFIG_PATH = 'magenest_colorswitcher/color_settings/custom_colors';

    public function getColorOptions()
    {
        $configData = $this->scopeConfig->getValue(self::CONFIG_PATH, ScopeInterface::SCOPE_STORE);

        if (!is_string($configData) || empty($configData)) {
            return [];
        }

        $decoded = json_decode($configData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->_logger->error('ColorSwitcher: Lỗi JSON - ' . json_last_error_msg());
            return [];
        }

        if (!is_array($decoded)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'label' => $item['name'] ?? 'Unnamed',
                'value' => $item['hex'] ?? '#FFFFF2'
            ];
        }, $decoded);
    }
}
