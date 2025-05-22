<?php
namespace Magenest\Blog\Plugin\Router;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;

class CustomRouter
{
    protected $blogCollectionFactory;
    protected $response;

    public function __construct(
        BlogCollectionFactory $blogCollectionFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->response = $response;
    }

    public function aroundMatch(
        RouterInterface $subject,
        \Closure $proceed,
        RequestInterface $request
    ) {
        $pathInfo = trim($request->getPathInfo(), '/');

        // Kiểm tra nếu pathInfo trùng url_rewrite blog
        $collection = $this->blogCollectionFactory->create()
            ->addFieldToFilter('url_rewrite', $pathInfo)
            ->setPageSize(1);

        if ($collection->getSize()) {
            $blog = $collection->getFirstItem();
            // Redirect nội bộ tới controller blog detail
            $request->setModuleName('blog')
                ->setControllerName('view')
                ->setActionName('index')
                ->setParam('id', $blog->getId());
            return $proceed($request);
        }

        // Nếu không tìm thấy thì chạy tiếp route bình thường
        return $proceed($request);
    }
}
