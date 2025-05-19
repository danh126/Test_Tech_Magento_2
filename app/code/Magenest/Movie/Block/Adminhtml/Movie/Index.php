<?php

namespace Magenest\Movie\Block\Adminhtml\Movie;

use Magento\Backend\Block\Template;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;

class Index extends Template
{
    protected $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getMovies()
    {
        return $this->collectionFactory->create();
    }

    public function getAddNewUrl()
    {
        return $this->getUrl('magenest/movie/add');
    }
}
