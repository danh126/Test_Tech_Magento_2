<?php

namespace Magenest\CourseProduct\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $attributes = [
            'course_start_datetime' => 'Course Start Datetime',
            'course_end_datetime' => 'Course End Datetime',
        ];

        foreach ($attributes as $code => $label) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                $code,
                [
                    'type' => 'datetime',
                    'backend' => '',
                    'frontend' => '',
                    'label' => $label,
                    'input' => 'date',
                    'class' => '',
                    'source' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => true,
                    'default' => '',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => '',
                    'group' => 'Product Details',
                ]
            );
        }

        $setup->endSetup();
    }
}
