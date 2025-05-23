<?php
namespace Magenest\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class FlushCacheObserver implements ObserverInterface
{
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    public function __construct(
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool
    ) {
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    public function execute(Observer $observer)
    {
        $object = $observer->getEvent()->getObject();

        // Chỉ xử lý với model blog của Magenest
        if ($object instanceof \Magenest\Blog\Model\Blog) {
            // Flush cache full page để áp dụng thay đổi ngay
            $this->cacheTypeList->cleanType('full_page');

            // Clean cache frontend pool (block cache, layout cache...)
            foreach ($this->cacheFrontendPool as $cacheFrontend) {
                $cacheFrontend->getBackend()->clean();
            }
        }
    }
}
