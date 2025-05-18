<?php
namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tables = [

            // Table: Magenest Director
            'magenest_director' => function () use ($setup) {
                return $setup->getConnection()->newTable($setup->getTable('magenest_director'))
                    ->addColumn(
                        'director_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'DIRECTOR ID'
                    )
                    ->addColumn(
                        'name',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        'NAME'
                    )
                    ->setComment('Magenest Director');
            },

            // Table: Magenest Movies
            'magenest_movie' => function () use ($setup) {
                return $setup->getConnection()->newTable($setup->getTable('magenest_movie'))
                    ->addColumn(
                        'movie_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'MOVIE ID'
                    )
                    ->addColumn(
                        'name',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        'NAME'
                    )
                    ->addColumn(
                        'description',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        'DESCRIPTION'
                    )
                    ->addColumn(
                        'rating',
                        Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false],
                        'RATING'
                    )
                    ->addColumn(
                        'director_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['unsigned' => true, 'nullable' => false],
                        'DIRECTOR ID'
                    )
                    ->addForeignKey(
                        $setup->getFkName('magenest_movie', 'director_id', 'magenest_director', 'director_id'),
                        'director_id',
                        $setup->getTable('magenest_director'),
                        'director_id',
                        Table::ACTION_CASCADE
                    )
                    ->setComment('Magenest Movies');
            },

            // Table: Magenest Actor
            'magenest_actor' => function () use ($setup) {
                return $setup->getConnection()->newTable($setup->getTable('magenest_actor'))
                    ->addColumn(
                        'actor_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'ACTOR ID'
                    )
                    ->addColumn(
                        'name',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        'NAME'
                    )
                    ->setComment('Magenest Actor');
            },

            // Table: Magenest Movies Actor (Many-to-Many)
            'magenest_movie_actor' => function () use ($setup) {
                return $setup->getConnection()->newTable($setup->getTable('magenest_movie_actor'))
                    ->addColumn(
                        'movie_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['unsigned' => true, 'nullable' => false],
                        'MOVIE ID'
                    )
                    ->addColumn(
                        'actor_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['unsigned' => true, 'nullable' => false],
                        'ACTOR ID'
                    )
                    ->addForeignKey(
                        $setup->getFkName('magenest_movie_actor', 'movie_id', 'magenest_movie', 'movie_id'),
                        'movie_id',
                        $setup->getTable('magenest_movie'),
                        'movie_id',
                        Table::ACTION_CASCADE
                    )
                    ->addForeignKey(
                        $setup->getFkName('magenest_movie_actor', 'actor_id', 'magenest_actor', 'actor_id'),
                        'actor_id',
                        $setup->getTable('magenest_actor'),
                        'actor_id',
                        Table::ACTION_CASCADE
                    )
                    ->setComment('Magenest Movies Actor');
            },
        ];

        // Create tables
        foreach ($tables as $tableName => $tableCallback) {
            if (!$setup->tableExists($tableName)) {
                $setup->getConnection()->createTable($tableCallback());
            }
        }

        $setup->endSetup();
    }
}
