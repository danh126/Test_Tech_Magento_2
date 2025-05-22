<?php
namespace Magenest\VnRegion\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Customer\Api\AddressMetadataInterface;

class AddVnRegionAttribute implements DataPatchInterface
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

            $attributeCode = 'vn_region';
            $entityType = 'customer_address';

            $eavSetup->addAttribute($entityType, $attributeCode, [
                'type' => 'int',
                'label' => 'VN Region',
                'input' => 'select',
                'source' => \Magenest\VnRegion\Model\Customer\Address\Attribute\Source\VnRegion::class,
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 210,
                'system' => 0,
            ]);

            $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);

            $entityTypeObj = $this->eavConfig->getEntityType($entityType);
            $attributeSetId = $entityTypeObj->getDefaultAttributeSetId();
            $attributeGroupId = $this->attributeSetFactory->create()->getDefaultGroupId($attributeSetId);

            $attribute->setData('attribute_set_id', $attributeSetId);
            $attribute->setData('attribute_group_id', $attributeGroupId);
            $attribute->setData('used_in_forms', [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]);

            $attribute->save();

            $connection->endSetup();
        } catch (\Exception $e) {
            $connection->endSetup();
            throw $e;
        }
    }

    public static function getDependencies() { return []; }
    public function getAliases() { return []; }
}
