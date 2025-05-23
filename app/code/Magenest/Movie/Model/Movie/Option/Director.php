<?php

namespace Magenest\Movie\Model\Movie\Option;

use Magento\Framework\Data\OptionSourceInterface;
use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory;

class Director implements OptionSourceInterface
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $options = [];

        foreach ($collection as $director) {
            $options[] = [
                'value' => $director->getId(),
                'label' => $director->getName()
            ];
        }

        return $options;
    }
}
