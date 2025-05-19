<?php
namespace Magenest\CustomerPhone\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Model\Config as EavConfig;

class AddTelephoneCustomerAttribute implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;
    private $attributeSetFactory;
    private $eavConfig;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        EavConfig $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->eavConfig = $eavConfig;
    }

    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $connection->startSetup();

        try {
            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

            $customerEntity = Customer::ENTITY;
            $attributeCode = 'telephone';

            // Thêm attribute
            $eavSetup->addAttribute($customerEntity, $attributeCode, [
                'type' => 'varchar',
                'label' => 'Telephone',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 150,
                'system' => 0,
                'validate_rules' => '{"max_text_length":10,"min_text_length":10}',
            ]);

            // Lấy attribute đã tạo bằng EavConfig
            $attribute = $this->eavConfig->getAttribute($customerEntity, $attributeCode);

            // Lấy attribute set id và group id chuẩn
            $entityType = $this->eavConfig->getEntityType($customerEntity);
            $attributeSetId = $entityType->getDefaultAttributeSetId();

            $attributeGroupId = $this->attributeSetFactory->create()->getDefaultGroupId($attributeSetId);

            $attribute->setData('attribute_set_id', $attributeSetId);
            $attribute->setData('attribute_group_id', $attributeGroupId);

            // Forms sẽ hiển thị attribute này
            $attribute->setData('used_in_forms', [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit',
                'adminhtml_checkout',
            ]);

            $attribute->save();

            $connection->endSetup();
        } catch (\Exception $e) {
            $connection->endSetup();
            throw $e;
        }
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
