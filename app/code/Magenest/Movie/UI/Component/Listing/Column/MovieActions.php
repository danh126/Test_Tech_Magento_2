<?php

namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class MovieActions extends Column
{
    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $id = $item['director_id'];
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl('magenest_movie/movie/edit', ['id' => $id]),
                    'label' => __('Edit')
                ];
                $item[$this->getData('name')]['delete'] = [
                    'href' => $this->urlBuilder->getUrl('magenest_movie/movie/delete', ['id' => $id]),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete "${ $.$data.name }"?'),
                        'message' => __('Are you sure you want to delete "${ $.$data.name }"?')
                    ]
                ];
            }
        }
        return $dataSource;
    }
}
