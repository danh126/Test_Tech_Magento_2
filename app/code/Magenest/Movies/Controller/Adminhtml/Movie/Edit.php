<?php

namespace Magenest\Movies\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magenest\Movies\Model\MovieFactory;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $movieFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        MovieFactory $movieFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->movieFactory = $movieFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->movieFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This movie no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Movies') : __('New Movies'));

        return $resultPage;
    }
}
