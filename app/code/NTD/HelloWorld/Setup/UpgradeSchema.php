<?php
namespace NTD\HelloWorld\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.2', '<')) {
            $connection = $setup->getConnection();
            $tableName = $setup->getTable('ntd_helloworld_subscription');

            if (!$connection->isTableExists($tableName)) {
                $table = $connection->newTable($tableName)
                    ->addColumn(
                        'subscription_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'Subscription ID'
                    )
                    ->addColumn(
                        'created_at',
                        Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                        'Created At'
                    )
                    ->addColumn(
                        'updated_at',
                        Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At'
                    )
                    ->addColumn(
                        'firstname',
                        Table::TYPE_TEXT,
                        64,
                        ['nullable' => false],
                        'First Name'
                    )
                    ->addColumn(
                        'lastname',
                        Table::TYPE_TEXT,
                        64,
                        ['nullable' => false],
                        'Last Name'
                    )
                    ->addColumn(
                        'email',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        'Email Address'
                    )
                    ->addColumn(
                        'status',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false, 'default' => 'pending'],
                        'Status'
                    )
                    ->addColumn(
                        'message',
                        Table::TYPE_TEXT,
                        '64k',
                        ['nullable' => false],
                        'Subscription Notes'
                    )
                    ->addIndex(
                        $setup->getIdxName($tableName, ['email']),
                        ['email']
                    )
                    ->setComment('NTD HelloWorld Subscription Table');

                $connection->createTable($table);
            }
        }

        $setup->endSetup();
    }
}
