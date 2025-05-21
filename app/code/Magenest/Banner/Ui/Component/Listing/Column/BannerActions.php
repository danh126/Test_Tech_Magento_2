<?php

namespace Magenest\Banner\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class BannerActions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    const EDIT_URL = 'magenest_banner/banner/edit';

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
                if (isset($item['banner_id'])) {
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::EDIT_URL,
                            ['banner_id' => $item['banner_id']]
                        ),
                        'label' => __('Edit'),
                    ];
                }
            }
        }
        return $dataSource;
    }
}
