<?php
namespace Magenest\CourseProduct\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magenest\CourseProduct\Model\DocumentFactory;
use Magenest\CourseProduct\Model\ResourceModel\Document as DocumentResource;

class SaveCourseDocuments implements ObserverInterface
{
    protected $documentFactory;
    protected $documentResource;

    public function __construct(
        DocumentFactory $documentFactory,
        DocumentResource $documentResource
    ) {
        $this->documentFactory = $documentFactory;
        $this->documentResource = $documentResource;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();

        $postData = $product->getData('course_documents');

        if ($postData && is_array($postData)) {
            $courseId = $product->getId();

            // Xoá tài liệu cũ liên quan
            $connection = $this->documentResource->getConnection();
            $tableName = $this->documentResource->getMainTable();
            $connection->delete($tableName, ['course_id = ?' => $courseId]);

            // Thêm lại tài liệu mới
            foreach ($postData as $documentData) {
                if (empty($documentData['document_name']) && empty($documentData['document_link'])) {
                    continue; // Bỏ qua nếu trống
                }
                $documentModel = $this->documentFactory->create();
                $documentModel->setCourseId($courseId);
                $documentModel->setDocumentName($documentData['document_name'] ?? '');
                $documentModel->setDocumentLink($documentData['document_link'] ?? '');
                $this->documentResource->save($documentModel);
            }
        }
    }
}
