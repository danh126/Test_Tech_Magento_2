<?php
namespace Magenest\Blog\Model;

use Magenest\Blog\Api\BlogRepositoryInterface;
use Magenest\Blog\Api\Data\BlogInterface;
use Magenest\Blog\Model\ResourceModel\Blog as BlogResource;
use Magenest\Blog\Model\BlogFactory;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Blog\Api\Data\BlogUpdateInterface;

class BlogRepository implements BlogRepositoryInterface
{
    protected $resource;
    protected $blogFactory;
    protected $collectionFactory;

    public function __construct(
        BlogResource $resource,
        BlogFactory $blogFactory,
        CollectionFactory $collectionFactory,
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->collectionFactory = $collectionFactory;
    }

    protected function validateUrlRewrite(BlogInterface $blog)
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('url_rewrite', $blog->getUrlRewrite())
            ->addFieldToFilter('id', ['neq' => $blog->getId()])
            ->setPageSize(1);

        if ($collection->getSize() > 0) {
            throw new LocalizedException(__('URL Rewrite already exists.'));
        }
    }

    public function save(BlogInterface $blog)
    {
        $this->validateUrlRewrite($blog);
        $this->resource->save($blog);
        return $blog;
    }

    public function update($id, BlogUpdateInterface $data)
    {
        $blog = $this->getById($id);
        if (!$blog->getId()) {
            throw new LocalizedException(__('Blog not found.'));
        }

        // Ví dụ set từng field, bạn thêm bớt trường tương ứng
        $blog->setTitle($data->getTitle());
        $blog->setContent($data->getContent());
        $blog->setUrlRewrite($data->getUrlRewrite());
        $blog->setAuthorId($data->getAuthorId());
        $blog->setStatus($data->getStatus());
        $blog->setDescription($data->getDescription());

        // Kiểm tra trùng url rewrite
        $this->validateUrlRewrite($blog);

        // Lưu
        $this->resource->save($blog);

        return $blog;
    }

    public function getAll()
    {
        $collection = $this->collectionFactory->create();

        $blogs = [];

        foreach ($collection->getItems() as $blog) {
            // $blog là instance của Blog model đã inject UserFactory rồi
            $blogs[] = [
                'id' => $blog->getId(),
                'title' => $blog->getTitle(),
                'content' => $blog->getContent(),
                'url_rewrite' => $blog->getUrlRewrite(),
                'author_id' => $blog->getAuthorId(),
                'author' => $blog->getAuthor(),  // lấy luôn info author ở đây
                'status' => $blog->getStatus(),
                'description' => $blog->getDescription(),
                'created_at' => $blog->getCreatedAt(),
                'updated_at' => $blog->getUpdatedAt(),
            ];
        }

        return $blogs;
    }

    public function getById($id)
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $id);

        if (!$blog->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Blog with id "%1" does not exist.', $id));
        }

        // Lấy thông tin author từ model Blog (trả về mảng hoặc null)
        $authorData = $blog->getAuthor();

        // Gán thông tin author vào blog để gọi ở view hoặc controller sau dễ dàng
        $blog->setData('author_data', $authorData);

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
