<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Movie\Model\DirectorFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $directorFactory;
    protected $registry;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        DirectorFactory $directorFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->directorFactory = $directorFactory;
        $this->registry = $registry;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->directorFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This actor no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $this->registry->register('current_actor', $model);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Actor') : __('Add Actor'));
        return $resultPage;
    }
}
