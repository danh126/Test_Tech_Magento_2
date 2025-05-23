<?php

use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $eavConfig;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        EavConfig $eavConfig
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(Customer::ENTITY, 'avatar', [
            'type' => 'varchar',
            'label' => 'Avatar',
            'input' => 'file',
            'required' => false,
            'visible' => true,
            'user_defined' => true,
            'position' => 150,
            'system' => 0,
            'backend' => 'Magenest\CustomerAvatar\Model\Attribute\Backend\Avatar',
        ]);

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'avatar');
        $attribute->setData('used_in_forms', [
            'adminhtml_customer',
            'customer_account_edit',
            'customer_register_account'
        ]);
        $attribute->save();

        $setup->endSetup();
    }
}
