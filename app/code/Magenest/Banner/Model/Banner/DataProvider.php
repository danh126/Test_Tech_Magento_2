<?php
namespace Magenest\Banner\Model\Banner;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magenest\Banner\Model\ResourceModel\Banner\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $banner) {
            $this->loadedData[$banner->getId()] = $banner->getData();
        }

        return $this->loadedData;
    }
}
