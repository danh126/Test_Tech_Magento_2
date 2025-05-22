<?php
namespace Magenest\ExportOrderItems\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

class Exportcsv extends Action
{
    protected $fileFactory;
    protected $directoryList;
    protected $orderCollectionFactory;

    public function __construct(
        Action\Context $context,
        FileFactory $fileFactory,
        DirectoryList $directoryList,
        OrderCollectionFactory $orderCollectionFactory
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->directoryList = $directoryList;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function execute()
    {
        $fileName = 'order_items.csv';
        $content = "order_id,item_id,sku,name,qty_ordered,price\n";

        // Lấy danh sách order
        $orders = $this->orderCollectionFactory->create();

        foreach ($orders as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                $content .= sprintf(
                    "%s,%s,%s,%s,%s,%s\n",
                    $order->getIncrementId(),
                    $item->getItemId(),
                    $item->getSku(),
                    $this->escapeCsv($item->getName()),
                    $item->getQtyOrdered(),
                    $item->getPrice()
                );
            }
        }

        return $this->fileFactory->create(
            $fileName,
            $content,
            'var'
        );
    }

    private function escapeCsv($value)
    {
        // Nếu tên sản phẩm có dấu phẩy thì bọc nó lại
        $value = str_replace('"', '""', $value);
        return '"' . $value . '"';
    }
}
