<?php

namespace Magenest\Movie\Block\Adminhtml\Movie;

use Magento\Backend\Block\Template;

class Add extends Template
{
    public function getFormAction()
    {
        return $this->getUrl('magenest/movie/save');
    }
}
