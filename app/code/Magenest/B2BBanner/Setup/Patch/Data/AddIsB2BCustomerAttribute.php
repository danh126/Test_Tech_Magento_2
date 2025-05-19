<?php

namespace Magenest\B2BBanner\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Model\Config as EavConfig;

class AddIsB2BCustomerAttribute implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private EavSetupFactory $eavSetupFactory;
    private AttributeSetFactory $attributeSetFactory;
    private EavConfig $eavConfig;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        EavConfig $eavConfig
    ) {
        $this->moduleDataSetup     = $moduleDataSetup;
        $this->eavSetupFactory     = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->eavConfig           = $eavConfig;
    }

    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $connection->startSetup();

        try {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

            $attributeCode = 'is_b2b';
            $entityType = Customer::ENTITY;

            $eavSetup->addAttribute($entityType, $attributeCode, [
                'type' => 'int',
                'label' => 'Is B2B',
                'input' => 'boolean',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 999,
                'system' => 0,
                'default' => 0,
            ]);

            $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);

            $entityTypeObj = $this->eavConfig->getEntityType($entityType);
            $attributeSetId = $entityTypeObj->getDefaultAttributeSetId();
            $attributeGroupId = $this->attributeSetFactory->create()->getDefaultGroupId($attributeSetId);

            $attribute->setData('attribute_set_id', $attributeSetId);
            $attribute->setData('attribute_group_id', $attributeGroupId);
            $attribute->setData('used_in_forms', [
                'adminhtml_customer',
                'customer_account_edit',
                'customer_account_create'
            ]);

            $attribute->save();

            $connection->endSetup();
        } catch (\Exception $e) {
            $connection->endSetup();
            throw $e;
        }
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
