<?php
namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magenest\Banner\Model\BannerFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Magenest_Banner::banner';

    protected $bannerFactory;

    public function __construct(Action\Context $context, BannerFactory $bannerFactory)
    {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('banner_id');
        if ($id) {
            try {
                $model = $this->bannerFactory->create();
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('Banner does not exist.'));
                    return $this->_redirect('*/*/');
                }
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Banner deleted.'));
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->_redirect('*/*/edit', ['banner_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('Unable to find banner to delete.'));
        return $this->_redirect('*/*/');
    }
}
