<?php

namespace Magenest\Movie\Model;

use Magento\Framework\Model\AbstractModel;

class Movie extends AbstractModel
{
    protected function _construct()
    {
        ManagerInterface $eventManager;

        $this->_init(\Magenest\Movie\Model\ResourceModel\Movie::class);
        $this->_eventManager = $eventManager;
    }

    public function afterSave()
    {
        $this->_eventManager->dispatch(
            'magenest_movie_save',
            ['movie' => $this]
        );
        return parent::afterSave();
    }
}
