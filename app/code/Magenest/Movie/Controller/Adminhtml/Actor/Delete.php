<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\DirectorFactory;

class Delete extends Action
{
    protected $directorFactory;

    public function __construct(Action\Context $context, DirectorFactory $directorFactory)
    {
        parent::__construct($context);
        $this->directorFactory = $directorFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->directorFactory->create()->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Actor deleted successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while deleting: ') . $e->getMessage());
            }
        }
        return $this->_redirect('*/*/');
    }
}
