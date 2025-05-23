<?php

namespace Magenest\CourseProduct\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class AddCourseDateTimeAttributes implements DataPatchInterface
{
    protected $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create();

        // Add course_start_datetime
        $eavSetup->addAttribute(Product::ENTITY, 'course_start_datetime', [
            'type' => 'datetime',
            'label' => 'Course Start Datetime',
            'input' => 'date',
            'backend' => '',
            'required' => false,
            'sort_order' => 210,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'user_defined' => true,
            'default' => '',
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
            'apply_to' => 'virtual',
        ]);

        // Add course_end_datetime
        $eavSetup->addAttribute(Product::ENTITY, 'course_end_datetime', [
            'type' => 'datetime',
            'label' => 'Course End Datetime',
            'input' => 'date',
            'backend' => '',
            'required' => false,
            'sort_order' => 211,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'user_defined' => true,
            'default' => '',
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
            'apply_to' => 'virtual',
        ]);

        return $this;
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
