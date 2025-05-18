<?php

namespace Magenest\EventDemo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ResetMovieRating implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $movie = $observer->getData('movie');
        $movie->setRating(0);
    }
}
