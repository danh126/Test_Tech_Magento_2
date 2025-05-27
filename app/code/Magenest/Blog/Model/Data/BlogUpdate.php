<?php
namespace Magenest\Blog\Model\Data;

use Magenest\Blog\Api\Data\BlogUpdateInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

class BlogUpdate extends AbstractExtensibleObject implements BlogUpdateInterface
{
    public function getTitle()
    {
        return $this->_get('title');
    }

    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    public function getContent()
    {
        return $this->_get('content');
    }

    public function setContent($content)
    {
        return $this->setData('content', $content);
    }

    public function getUrlRewrite()
    {
        return $this->_get('url_rewrite');
    }

    public function setUrlRewrite($urlRewrite)
    {
        return $this->setData('url_rewrite', $urlRewrite);
    }

    public function getAuthorId()
    {
        return $this->_get('author_id');
    }

    public function setAuthorId($authorId)
    {
        return $this->setData('author_id', $authorId);
    }

    public function getStatus()
    {
        return $this->_get('status');
    }

    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    public function getDescription()
    {
        return $this->_get('description');
    }

    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }
}
