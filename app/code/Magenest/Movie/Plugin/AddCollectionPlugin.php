<?php

namespace Magenest\Movie\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;
use Psr\Log\LoggerInterface;

class AddCollectionPlugin
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function afterCreate(
        CollectionFactory $subject,
                          $result,
                          $requestName = null
    ) {
        $this->logger->info('AddCollectionPlugin afterCreate called with requestName: ' . $requestName);

        $map = [
            'magenest_movie_listing_data_source' => \Magenest\Movie\Ui\DataProvider\Movie\Collection::class,
            'magenest_director_listing_data_source' => \Magenest\Movie\Ui\DataProvider\Director\Collection::class,
            'magenest_actor_listing_data_source' => \Magenest\Movie\Ui\DataProvider\Actor\Collection::class,
            'magenest_movie_form_data_source' => \Magenest\Movie\Ui\DataProvider\Movie\Collection::class,
        ];

        if ($requestName !== null && isset($map[$requestName])) {
            $this->logger->info('Custom collection found for ' . $requestName);
            $result = \Magento\Framework\App\ObjectManager::getInstance()->get($map[$requestName]);
        }

        return $result;
    }
}
