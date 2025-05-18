<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\MovieFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action
{
    protected $movieFactory;
    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        MovieFactory $movieFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->movieFactory = $movieFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        try {
            $id = $this->getRequest()->getParam('movie_id');
            $model = $this->movieFactory->create();

            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            if ($model->getRating() <= 0) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Rating must be greater than 0.'));
            }

            $model->save();
            $this->messageManager->addSuccessMessage(__('Movie saved successfully.'));

            $this->dataPersistor->clear('magenest_movie');
            return $this->resultRedirectFactory->create()->setPath('*/*/');

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('magenest_movie', $data);
            return $this->resultRedirectFactory->create()->setPath('*/*/edit', ['movie_id' => $id]);
        }
    }
}
