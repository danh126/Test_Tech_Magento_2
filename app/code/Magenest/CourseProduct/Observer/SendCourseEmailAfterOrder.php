<?php
namespace Magenest\CourseProduct\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

class SendCourseEmailAfterOrder implements ObserverInterface
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;

    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();

        // Chỉ gửi email khi order status complete (hoặc bạn chỉnh trạng thái phù hợp)
        if ($order->getState() !== 'complete') {
            return;
        }

        $customerEmail = $order->getCustomerEmail();
        $customerName = $order->getCustomerName();

        // Lấy các sản phẩm khóa học trong đơn (bạn custom cách xác định khóa học)
        $items = $order->getAllVisibleItems();
        $courseItems = [];
        foreach ($items as $item) {
            $product = $item->getProduct();
            // Giả sử khóa học có attribute is_course = 1
            if ($product->getData('is_course')) {
                $courseItems[] = $product;
            }
        }

        if (empty($courseItems)) {
            return; // ko có khóa học thì thôi
        }

        // Lấy dữ liệu tài liệu tham khảo cho mỗi khóa học
        // Giả sử bạn có model để lấy tài liệu theo product id
        $courseMaterialsData = [];
        foreach ($courseItems as $course) {
            $courseMaterialsData[$course->getName()] = $this->getMaterialsByCourseId($course->getId());
        }

        try {
            $this->inlineTranslation->suspend();

            $transport = $this->transportBuilder
                ->setTemplateIdentifier('magenest_course_email_template') // email template identifier trong etc/email_templates.xml
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars([
                    'customer_name' => $customerName,
                    'course_materials' => $courseMaterialsData,
                    'order' => $order,
                ])
                ->setFromByScope(['email' => 'general@example.com', 'name' => 'Your Store']) // bạn thay bằng config mail
                ->addTo($customerEmail, $customerName)
                ->getTransport();

            $transport->sendMessage();

            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            // Log lỗi
        }
    }

    protected function getMaterialsByCourseId($courseId)
    {
        // Trả về mảng dữ liệu tài liệu, ví dụ:
        return [
            ['title' => 'Tài liệu 1', 'link' => 'https://example.com/file1.pdf'],
            ['title' => 'Tài liệu 2', 'link' => 'https://example.com/file2.pdf'],
        ];
    }
}
