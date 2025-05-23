<?php
namespace Magenest\AccessTime\Plugin;

use Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider;
use Magenest\AccessTime\Model\ResourceModel\AccessTime as AccessTimeResource;

class ProductDataProviderPlugin
{
    protected $accessTimeResource;

    public function __construct(AccessTimeResource $accessTimeResource)
    {
        $this->accessTimeResource = $accessTimeResource;
    }

    public function afterGetData(ProductDataProvider $subject, $result)
    {
        foreach ($result as $productId => &$productData) {
            // Lấy data access_time từ DB
            $accessTimeData = $this->accessTimeResource->getAccessTimeDataByProductId($productId);
            if ($accessTimeData) {
                // Mảng groupId => days convert thành JSON string để điền textarea
                $productData['access_time_data'] = json_encode($accessTimeData);
            }
        }
        return $result;
    }
}
