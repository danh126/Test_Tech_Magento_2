<?php
namespace Magenest\ExportOrderItems\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderItems extends Action
{
    protected $fileFactory;
    protected $orderCollectionFactory;
    protected $directoryList;
    protected $orderRepository;

    public function __construct(
        Action\Context $context,
        FileFactory $fileFactory,
        OrderCollectionFactory $orderCollectionFactory,
        DirectoryList $directoryList,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->fileFactory = $fileFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->directoryList = $directoryList;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $fileName = 'order_items_export.csv';
        $content = '';

        $header = [
            'Order ID', 'Order Date', 'Customer Name', 'Email',
            'Product Name', 'SKU', 'Price', 'Qty', 'Row Total',
            'Shipping Address', 'Payment Method'
        ];

        $content .= implode(',', $header) . "\n";

        $orderCollection = $this->orderCollectionFactory->create();
        foreach ($orderCollection as $order) {
            $orderData = $this->orderRepository->get($order->getId());

            $customerName = $orderData->getCustomerFirstname() . ' ' . $orderData->getCustomerLastname();
            $email = $orderData->getCustomerEmail();
            $orderDate = $orderData->getCreatedAt();
            $orderId = $orderData->getIncrementId();

            $shippingAddress = $orderData->getShippingAddress();
            $shipping = $shippingAddress ?
                $shippingAddress->getStreetLine(1) . ' ' . $shippingAddress->getCity() : 'N/A';

            $payment = $orderData->getPayment() ? $orderData->getPayment()->getMethod() : 'N/A';

            foreach ($orderData->getAllVisibleItems() as $item) {
                $row = [
                    $orderId,
                    $orderDate,
                    $customerName,
                    $email,
                    $item->getName(),
                    $item->getSku(),
                    $item->getPrice(),
                    $item->getQtyOrdered(),
                    $item->getRowTotal(),
                    $shipping,
                    $payment
                ];
                $content .= '"' . implode('","', $row) . "\"\n";
            }
        }

        return $this->fileFactory->create(
            $fileName,
            $content,
            DirectoryList::VAR_DIR,
            'text/csv'
        );
    }
}
