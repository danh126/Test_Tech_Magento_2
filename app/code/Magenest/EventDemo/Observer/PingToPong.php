<?php

namespace Magenest\EventDemo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class PingToPong implements ObserverInterface
{
    protected $configWriter;

    public function __construct(WriterInterface $configWriter)
    {
        $this->configWriter = $configWriter;
    }

    public function execute(Observer $observer)
    {
        $textFieldValue = $observer->getEvent()->getData('website')->getConfigValue('magenest_config/text_field');

        if ($textFieldValue === 'Ping') {
            $this->configWriter->save(
                'magenest_config/text_field',
                'Pong'
            );
        }
    }
}
