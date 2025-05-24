<?php
namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\ResultFactory;
use Magenest\Banner\Model\BannerFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Magenest_Banner::banner';

    protected $bannerFactory;
    protected $uploaderFactory;
    protected $filesystem;

    public function __construct(
        Action\Context $context,
        BannerFactory $bannerFactory,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('*/*/');
        }

        $model = $this->bannerFactory->create();

        $id = $this->getRequest()->getParam('banner_id');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        // Handle image upload (optional)
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            try {
                $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);

                $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
                $result = $uploader->save($mediaDirectory->getAbsolutePath('magenest/banner'));

                if ($result) {
                    $data['image'] = 'magenest/banner' . $result['file'];
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            // keep old image if editing and no new image uploaded
            if (isset($data['image']['delete']) && $data['image']['delete'] == 1) {
                $data['image'] = null;
            } elseif (isset($data['image']['value'])) {
                $data['image'] = $data['image']['value'];
            }
        }

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('Banner saved.'));
            $this->_getSession()->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                return $this->_redirect('*/*/edit', ['banner_id' => $model->getId()]);
            }
            return $this->_redirect('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->_getSession()->setFormData($data);
        return $this->_redirect('*/*/edit', ['banner_id' => $id]);
    }
}
