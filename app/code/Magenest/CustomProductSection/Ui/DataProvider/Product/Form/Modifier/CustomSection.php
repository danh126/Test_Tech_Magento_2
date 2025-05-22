<?php

namespace Magenest\CustomProductSection\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class CustomSection implements ModifierInterface
{
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data)
    {
        return $data;
    }
}
