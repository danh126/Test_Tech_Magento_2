<?php
namespace Magenest\Blog\Controller\Router;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\ActionFactory;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory;

class CustomRouter implements RouterInterface
{
    protected $response;
    protected $actionFactory;
    protected $blogCollectionFactory;

    public function __construct(
        ResponseInterface $response,
        ActionFactory $actionFactory,
        CollectionFactory $blogCollectionFactory
    ) {
        $this->response = $response;
        $this->actionFactory = $actionFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    public function match(RequestInterface $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');

        $collection = $this->blogCollectionFactory->create()
            ->addFieldToFilter('url_rewrite', $pathInfo)
            ->setPageSize(1);

        if (!$collection->getSize()) {
            return false; // Không bắt route này, để Magento xử lý tiếp
        }

        $blog = $collection->getFirstItem();

        // Tránh loop: nếu module đã là 'blog' thì đừng match tiếp (optional)
        if ($request->getModuleName() === 'blog') {
            return false;
        }

        $request->setModuleName('blog')
            ->setControllerName('view')
            ->setActionName('index')
            ->setParam('id', $blog->getId());

        // Trả về action Forward, nhớ truyền $request vào
        return $this->actionFactory->create(
            \Magento\Framework\App\Action\Forward::class,
            ['request' => $request]
        );
    }
}
