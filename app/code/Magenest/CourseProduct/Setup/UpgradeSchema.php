<?php
namespace Magenest\CourseProduct\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            if (!$setup->tableExists('magenest_course_documents')) {
                $table = $setup->getConnection()->newTable(
                    $setup->getTable('magenest_course_documents')
                )->addColumn(
                    'document_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Document ID'
                )->addColumn(
                    'course_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Course Product ID'
                )->addColumn(
                    'document_name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Document Name'
                )->addColumn(
                    'document_link',
                    Table::TYPE_TEXT,
                    1024,
                    ['nullable' => false],
                    'Document Link or File Path'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default' => Table::TIMESTAMP_INIT
                    ],
                    'Created At'
                )->setComment('Course Documents Table');

                $setup->getConnection()->createTable($table);
            }
        }

        $setup->endSetup();
    }
}
