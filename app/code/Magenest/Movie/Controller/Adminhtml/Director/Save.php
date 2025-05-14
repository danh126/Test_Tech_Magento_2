<?php

namespace Magenest\Director\Controller\Adminhtml\Director;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\DirectorFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action {
    protected $directorFactory;
    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->directorFactory = $directorFactory;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute() {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->directorFactory->create();
            $id = $this->getRequest()->getParam('director_id');

            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('Director saved successfully.'));
                $this->dataPersistor->clear('magenest_director');
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error saving director: ') . $e->getMessage());
                $this->dataPersistor->set('magenest_director', $data);
                return $this->_redirect('*/*/edit', ['id' => $id]);
            }
        }

        return $this->_redirect('*/*/');
    }
}
