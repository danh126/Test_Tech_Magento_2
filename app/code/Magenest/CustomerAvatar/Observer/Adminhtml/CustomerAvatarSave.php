<?php
namespace Magenest\CustomerAvatar\Observer\Adminhtml;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class CustomerAvatarSave implements ObserverInterface
{
    protected $uploaderFactory;
    protected $filesystem;

    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        if (isset($_FILES['avatar']) && $_FILES['avatar']['name']) {
            try {
                $uploader = $this->uploaderFactory->create(['fileId' => 'avatar']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);

                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $target = $mediaDirectory->getAbsolutePath('customer');

                $result = $uploader->save($target);

                if ($result['file']) {
                    $path = 'customer/' . $result['file'];
                    $customer->setData('avatar', $path); // ✅ Gắn avatar để lưu DB
                }
            } catch (\Exception $e) {
                // log nếu cần
            }
        }
    }
}
