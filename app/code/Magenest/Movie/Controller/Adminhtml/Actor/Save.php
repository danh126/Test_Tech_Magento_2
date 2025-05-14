<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\DirectorFactory;

class Save extends Action
{
    protected $directorFactory;

    public function __construct(Action\Context $context, DirectorFactory $directorFactory)
    {
        parent::__construct($context);
        $this->directorFactory = $directorFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $model = $this->directorFactory->create();
                if (isset($data['actor_id'])) {
                    $model->load($data['actor_id']);
                }
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__('Actor saved successfully.'));
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while saving director: ') . $e->getMessage());
                return $this->_redirect('*/*/edit', ['id' => $data['actor_id'] ?? null]);
            }
        }
        return $this->_redirect('*/*/');
    }
}
