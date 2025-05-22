<?php
namespace Magenest\CustomerAvatar\Model\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class Avatar extends AbstractBackend
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

    public function beforeSave($object)
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();

        $value = $object->getData($attributeCode);

        if (is_array($value) && isset($value[0]['name']) && isset($value[0]['tmp_name'])) {
            $file = $value[0];
            if (isset($file['tmp_name']) && $file['tmp_name']) {
                try {
                    $uploader = $this->uploaderFactory->create(['fileId' => $attributeCode]);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save($mediaDirectory->getAbsolutePath('customer/avatar'));

                    if (!$result) {
                        throw new LocalizedException(__('File cannot be saved to path: %1', $mediaDirectory->getAbsolutePath('customer/avatar')));
                    }

                    $filePath = 'customer/avatar' . $result['file'];
                    $object->setData($attributeCode, $filePath);
                } catch (\Exception $e) {
                    throw new LocalizedException(__('Avatar upload error: %1', $e->getMessage()));
                }
            }
        } elseif (is_string($value) && $value === '') {
            $object->setData($attributeCode, null);
        }

        return parent::beforeSave($object);
    }
}
