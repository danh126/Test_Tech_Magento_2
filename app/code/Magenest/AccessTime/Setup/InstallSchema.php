<?php
namespace Magenest\AccessTime\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Tạo bảng magenest_access_time
        if (!$setup->tableExists('magenest_access_time')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('magenest_access_time')
            )
                ->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Product ID'
                )
                ->addColumn(
                    'customer_group_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Customer Group ID'
                )
                ->addColumn(
                    'access_time_days',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'default' => 0],
                    'Access Time in Days'
                )
                ->addIndex(
                    $setup->getIdxName('magenest_access_time', ['product_id', 'customer_group_id']),
                    ['product_id', 'customer_group_id'],
                    ['unique' => true]
                )
                ->setComment('Access Time per Customer Group for Products');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
