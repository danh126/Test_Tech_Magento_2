<?php

namespace NTD\HelloWorld\Plugin\Catalog;

use Magento\Catalog\Model\Product;

class ProductAroundCustom
{
    public function aroundGetName($interceptedInput)
    {
        return "Name of product";
    }
}

