<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\MovieFactory;

class Save extends Action
{
    protected $directorFactory;

    public function __construct(Action\Context $context, MovieFactory $directorFactory)
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
                if (isset($data['movie_id'])) {
                    $model->load($data['movie_id']);
                }
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__('Movie saved successfully.'));
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while saving director: ') . $e->getMessage());
                return $this->_redirect('*/*/edit', ['id' => $data['movie_id'] ?? null]);
            }
        }
        return $this->_redirect('*/*/');
    }
}
