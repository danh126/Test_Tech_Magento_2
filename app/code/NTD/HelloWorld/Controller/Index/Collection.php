<?php

namespace NTD\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\Result\RawFactory;

class Collection extends Action
{
    protected $productCollectionFactory;
    protected $resultRawFactory;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->resultRawFactory = $resultRawFactory;
    }

    public function execute()
    {
        // Tạo collection
        $collection = $this->productCollectionFactory->create();
        $collection->setPageSize(10); // Giới hạn 10 sản phẩm

        // Gán output
        $output = '';

        foreach ($collection as $product) {
            $output .= '<pre>' . print_r($product->getData(), true) . '</pre>';
        }

        // Trả ra response kiểu RAW
        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setContents($output);
        return $resultRaw;
    }
}
