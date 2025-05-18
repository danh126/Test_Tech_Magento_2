<?php
namespace Magenest\CustomDashboard\Block\Adminhtml;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceFactory;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory as CreditmemoFactory;

class Stats extends Template
{
    protected $moduleList;
    protected $customerFactory;
    protected $productFactory;
    protected $orderFactory;
    protected $invoiceFactory;
    protected $creditmemoFactory;

    public function __construct(
        Template\Context $context,
        ModuleListInterface $moduleList,
        CustomerFactory $customerFactory,
        ProductFactory $productFactory,
        OrderFactory $orderFactory,
        InvoiceFactory $invoiceFactory,
        CreditmemoFactory $creditmemoFactory,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
        $this->customerFactory = $customerFactory;
        $this->productFactory = $productFactory;
        $this->orderFactory = $orderFactory;
        $this->invoiceFactory = $invoiceFactory;
        $this->creditmemoFactory = $creditmemoFactory;
    }

    public function getMagentoModulesCount() {
        $modules = $this->moduleList->getAll();
        return count(array_filter(array_keys($modules), fn($name) => str_starts_with($name, 'Magento_')));
    }

    public function getCustomModulesCount() {
        $modules = $this->moduleList->getAll();
        return count(array_filter(array_keys($modules), fn($name) => !str_starts_with($name, 'Magento_')));
    }

    public function getCustomerCount() {
        return $this->customerFactory->create()->getSize();
    }

    public function getProductCount() {
        return $this->productFactory->create()->getSize();
    }

    public function getOrderCount() {
        return $this->orderFactory->create()->getSize();
    }

    public function getInvoiceCount() {
        return $this->invoiceFactory->create()->getSize();
    }

    public function getCreditmemoCount() {
        return $this->creditmemoFactory->create()->getSize();
    }
}
