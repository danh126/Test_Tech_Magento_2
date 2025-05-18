<?php

namespace Magenest\Movie\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSampleData implements DataPatchInterface
{
    private $moduleDataSetup;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $connection = $setup->getConnection();
        $setup->startSetup();

        // Insert Directors
        $connection->insertMultiple(
            $setup->getTable('magenest_director'),
            [
                ['name' => 'Christopher Nolan'],
                ['name' => 'James Cameron'],
                ['name' => 'Quentin Tarantino'],
            ]
        );

        // Insert Actors
        $connection->insertMultiple(
            $setup->getTable('magenest_actor'),
            [
                ['name' => 'Leonardo DiCaprio'],
                ['name' => 'Brad Pitt'],
                ['name' => 'Tom Hardy'],
            ]
        );

        // Get director IDs
        $directorIds = $connection->fetchCol("SELECT director_id FROM " . $setup->getTable('magenest_director'));

        // Insert Movies
        $connection->insertMultiple(
            $setup->getTable('magenest_movie'),
            [
                [
                    'name' => 'Inception',
                    'description' => 'A mind-bending thriller',
                    'rating' => 9,
                    'director_id' => $directorIds[0] ?? 1
                ],
                [
                    'name' => 'Titanic',
                    'description' => 'A tragic love story',
                    'rating' => 8,
                    'director_id' => $directorIds[1] ?? 2
                ],
            ]
        );

        // Get movie and actor IDs
        $movieIds = $connection->fetchCol("SELECT movie_id FROM " . $setup->getTable('magenest_movie'));
        $actorIds = $connection->fetchCol("SELECT actor_id FROM " . $setup->getTable('magenest_actor'));

        // Insert Movie-Actor relationships
        $connection->insertMultiple(
            $setup->getTable('magenest_movie_actor'),
            [
                ['movie_id' => $movieIds[0] ?? 1, 'actor_id' => $actorIds[0] ?? 1],
                ['movie_id' => $movieIds[0] ?? 1, 'actor_id' => $actorIds[2] ?? 3],
                ['movie_id' => $movieIds[1] ?? 2, 'actor_id' => $actorIds[0] ?? 1],
            ]
        );

        $setup->endSetup();
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
