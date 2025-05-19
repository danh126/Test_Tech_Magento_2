<?php
namespace Magenest\Blog\Model;

use Magenest\Blog\Api\BlogRepositoryInterface;
use Magenest\Blog\Api\Data\BlogInterface;
use Magenest\Blog\Model\ResourceModel\Blog as BlogResource;
use Magenest\Blog\Model\BlogFactory;
use Magento\Framework\Exception\LocalizedException;

class BlogRepository implements BlogRepositoryInterface
{
    protected $resource;
    protected $blogFactory;

    public function __construct(
        BlogResource $resource,
        BlogFactory $blogFactory
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
    }

    public function save(BlogInterface $blog)
    {
        $existingBlog = $this->blogFactory->create();
        $this->resource->load($existingBlog, $blog->getUrlRewrite(), 'url_rewrite');
        if ($existingBlog->getId() && $existingBlog->getId() != $blog->getId()) {
            throw new LocalizedException(__('URL Rewrite already exists.'));
        }

        $this->resource->save($blog);
        return $blog;
    }

    public function getById($id)
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $id);
        return $blog;
    }

    public function delete(BlogInterface $blog)
    {
        $this->resource->delete($blog);
        return true;
    }

    public function deleteById($id)
    {
        $blog = $this->getById($id);
        return $this->delete($blog);
    }
}
