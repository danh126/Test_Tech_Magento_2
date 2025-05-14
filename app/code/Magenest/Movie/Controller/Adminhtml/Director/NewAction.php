<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Backend\App\Action;

class NewAction extends Action {
    public function execute() {
        return $this->_redirect('*/*/edit');
    }
}
