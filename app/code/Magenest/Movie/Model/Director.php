<?php

namespace Magenest\Movie\Model;

use Magento\Framework\Model\AbstractModel;

class Director extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magenest\Movie\Model\ResourceModel\Director::class);
    }

    public function getId()
    {
        return $this->getData('director_id');
    }

    public function setId($value)
    {
        return $this->setData('director_id', $value);
    }

}
