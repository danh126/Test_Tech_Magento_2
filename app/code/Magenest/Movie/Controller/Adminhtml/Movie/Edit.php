<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Movie\Model\MovieFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $movieFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory, MovieFactory $movieFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->movieFactory = $movieFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $movie = $this->movieFactory->create();

        if ($id) {
            $movie->load($id);
            if (!$movie->getId()) {
                $this->messageManager->addErrorMessage(__('This movie no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Movie::movie');
        $resultPage->addBreadcrumb(__('Movie'), __('Movie'));
        $resultPage->addBreadcrumb(__('Manage Movies'), __('Manage Movies'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Movie') : __('Add New Movie'));

        return $resultPage;
    }
}
