<?php
namespace Magenest\Blog\Api\Data;

interface BlogUpdateInterface
{
    /**
     * Get blog title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set blog title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get blog content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set blog content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Get blog URL rewrite
     *
     * @return string|null
     */
    public function getUrlRewrite();

    /**
     * Set blog URL rewrite
     *
     * @param string $urlRewrite
     * @return $this
     */
    public function setUrlRewrite($urlRewrite);

    /**
     * Get author ID
     *
     * @return int|null
     */
    public function getAuthorId();

    /**
     * Set author ID
     *
     * @param int $authorId
     * @return $this
     */
    public function setAuthorId($authorId);

    /**
     * Get blog status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set blog status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get blog description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set blog description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description);
}
