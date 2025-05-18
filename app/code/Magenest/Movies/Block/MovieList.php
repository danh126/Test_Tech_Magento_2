<?php

namespace Magenest\Movies\Block;

use Magento\Framework\View\Element\Template;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;

class MovieList extends Template
{
    protected $movieCollectionFactory;

    public function __construct(
        Template\Context $context,
        MovieCollectionFactory $movieCollectionFactory,
        array $data = []
    ) {
        $this->movieCollectionFactory = $movieCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getMovieCollection()
    {
        $collection = $this->movieCollectionFactory->create();
        $collection->getSelect()
            ->joinLeft(
                ['d' => 'magenest_director'],
                'main_table.director_id = d.director_id',
                ['director_name' => 'd.name']
            )
            ->joinLeft(
                ['ma' => 'magenest_movie_actor'],
                'main_table.movie_id = ma.movie_id',
                []
            )
            ->joinLeft(
                ['a' => 'magenest_actor'],
                'ma.actor_id = a.actor_id',
                ['actor_name' => 'a.name']
            )
            ->group('main_table.movie_id');

        return $collection;
    }
}
