<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\MovieFactory;

class Save extends Action
{
    protected $movieFactory;

    public function __construct(Action\Context $context, MovieFactory $movieFactory)
    {
        parent::__construct($context);
        $this->movieFactory = $movieFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $movie = $this->movieFactory->create();
            $movie->setData($data);
            $movie->save();
            $this->messageManager->addSuccessMessage(__('Movies saved successfully.'));
        }

        return $this->_redirect('magenest/movie/index');
    }
}
