<?php

namespace Magenest\Movie\Model\Movie;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;
use Magento\Framework\App\RequestInterface;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $loadedData;
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $movieId = $this->request->getParam('id');

        if ($movieId) {
            $movie = $this->collection->getItemById($movieId);
            if ($movie) {
                $this->loadedData[$movieId] = $movie->getData();
            } else {
                // Không tìm thấy ID → tránh lỗi
                $this->loadedData[$movieId] = [];
            }
        } else {
            // Form Add New → dữ liệu mặc định rỗng
            $this->loadedData['new'] = [
                'movie_id' => null,
                'name' => '',
                'description' => '',
                'rating' => '',
                'director_id' => ''
            ];
        }

        return $this->loadedData;
    }
}
