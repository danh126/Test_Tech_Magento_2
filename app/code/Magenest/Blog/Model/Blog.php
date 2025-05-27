<?php
namespace Magenest\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Magenest\Blog\Api\Data\BlogInterface;
use Magento\User\Model\UserFactory;

class Blog extends AbstractModel implements BlogInterface
{
    /**
     * @var UserFactory
     */
    protected $userFactory;

    /**
     * Cache author data để tránh load nhiều lần
     *
     * @var array|null
     */
    protected $authorData = null;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        UserFactory $userFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->userFactory = $userFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init(\Magenest\Blog\Model\ResourceModel\Blog::class);
    }

    /**
     * Lấy thông tin tác giả (author) từ bảng admin_user
     *
     * @return array|null
     */
    public function getAuthor()
    {
        if ($this->authorData !== null) {
            return $this->authorData;
        }

        $authorId = $this->getAuthorId();
        if (!$authorId) {
            return null;
        }

        $user = $this->userFactory->create()->load($authorId);

        if (!$user->getId()) {
            return null; // Author không tồn tại
        }

        $this->authorData = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname()
        ];

        return $this->authorData;
    }

    public function setAuthor($author)
    {
        return $this->setData('author', $author);
    }

    // --- Interface methods ---

    public function getId()
    {
        return $this->getData('id');
    }

    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    public function getAuthorId()
    {
        return $this->getData('author_id');
    }

    public function setAuthorId($authorId)
    {
        return $this->setData('author_id', $authorId);
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    public function getDescription()
    {
        return $this->getData('description');
    }

    public function setDescription($desc)
    {
        return $this->setData('description', $desc);
    }

    public function getContent()
    {
        return $this->getData('content');
    }

    public function setContent($content)
    {
        return $this->setData('content', $content);
    }

    public function getUrlRewrite()
    {
        return $this->getData('url_rewrite');
    }

    public function setUrlRewrite($url)
    {
        return $this->setData('url_rewrite', $url);
    }

    public function getStatus()
    {
        return $this->getData('status');
    }

    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData('created_at', $createdAt);
    }

    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData('updated_at', $updatedAt);
    }
}
