<?php
namespace Magenest\Blog\Api;

use Magenest\Blog\Api\Data\BlogInterface;

interface BlogRepositoryInterface
{
    /**
     * Save blog data
     *
     * @param \Magenest\Blog\Api\Data\BlogInterface $blog
     * @return \Magenest\Blog\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(BlogInterface $blog);

    /**
     * Get blog by ID
     *
     * @param int $id
     * @return \Magenest\Blog\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * Delete blog
     *
     * @param \Magenest\Blog\Api\Data\BlogInterface $blog
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(BlogInterface $blog);

    /**
     * Delete blog by ID
     *
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);
}
