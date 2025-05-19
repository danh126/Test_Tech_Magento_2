<?php
namespace Magenest\Blog\Controller\View;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Blog\Model\BlogFactory;

class Index extends Action
{
    protected $resultPageFactory;
    protected $blogFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BlogFactory $blogFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $blog = $this->blogFactory->create()->load($id);

        if (!$blog->getId()) {
            // Redirect hoặc 404
            $this->_redirect('noroute');
            return;
        }

        // Đưa data blog vào registry hoặc block nếu cần
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($blog->getTitle());
        return $resultPage;
    }
}
