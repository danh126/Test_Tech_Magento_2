<?php

namespace Magenest\Movie\Model;

use Magento\Framework\Model\AbstractModel;

class Actor extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magenest\Movie\Model\ResourceModel\Actor::class);
    }

    public function getId()
    {
        return $this->getData('actor_id');
    }

    public function setId($value)
    {
        return $this->setData('actor_id', $value);
    }

}
