<?php
namespace Magenest\CourseProduct\Plugin;

use Magento\Catalog\Model\Product\DataProvider;
use Magenest\CourseProduct\Model\ResourceModel\Document\CollectionFactory as DocumentCollectionFactory;

class ProductDataProviderPlugin
{
    protected $documentCollectionFactory;

    public function __construct(
        DocumentCollectionFactory $documentCollectionFactory
    ) {
        $this->documentCollectionFactory = $documentCollectionFactory;
    }

    public function afterGetData(DataProvider $subject, $result)
    {
        foreach ($result as $productId => $productData) {
            $collection = $this->documentCollectionFactory->create();
            $collection->addFieldToFilter('course_id', $productId);

            $documents = [];
            foreach ($collection as $doc) {
                $documents[] = [
                    'document_name' => $doc->getDocumentName(),
                    'document_link' => $doc->getDocumentLink()
                ];
            }

            $result[$productId]['course_documents'] = $documents;
        }

        return $result;
    }
}
