<?php
namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magenest\Banner\Model\BannerFactory;

class Edit extends Action
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
        $model = $this->bannerFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $this->_getSession()->setFormData(false);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Banner %1', $model->getName()) : __('New Banner'));

        $this->_addBreadcrumb($id ? __('Edit Banner') : __('New Banner'), $id ? __('Edit Banner') : __('New Banner'));

        return $resultPage;
    }
}
