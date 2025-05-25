<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Movie\Model\MovieFactory;

class Save extends Action
{
    protected $movieFactory;

    public function __construct(
        Action\Context $context,
        MovieFactory $movieFactory
    ) {
        $this->movieFactory = $movieFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $movieId = isset($data['data']['movie_id']) ? $data['data']['movie_id'] : null;
                $movie = $this->movieFactory->create();

                if ($movieId) {
                    $movie->load($movieId);
                    if (!$movie->getId()) {
                        throw new LocalizedException(__('This movie no longer exists.'));
                    }
                } else {
                    unset($data['data']['movie_id']);
                }

                $movie->setData($data['data']);

                $this->_eventManager->dispatch(
                    'magenest_movie_save',
                    ['movie' => $movie]
                );

                $movie->save();
                $this->messageManager->addSuccessMessage(__('The movie has been saved successfully.'));
                $this->_getSession()->unsFormData();


                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $movie->getId()]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $movieId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the movie.'));
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $movieId]);
            }
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
