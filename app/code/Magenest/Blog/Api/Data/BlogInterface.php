<?php
namespace Magenest\Blog\Api\Data;

interface BlogInterface
{
    /**
     * Get blog ID
     *
     * @return int
     */
    public function getId();

    /**
     * Set blog ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get blog title
     *
     * @return string
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
     * @return string
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
     * @return string
     */
    public function getUrlRewrite();

    /**
     * Set blog URL rewrite
     *
     * @param string $url
     * @return $this
     */
    public function setUrlRewrite($url);

    /**
     * Get author ID
     *
     * @return int
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
     * @return int
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
     * @return string
     */
    public function getDescription();

    /**
     * Set blog description
     *
     * @param string $desc
     * @return $this
     */
    public function setDescription($desc);

    /**
     * Get created at datetime
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set created at datetime
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at datetime
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated at datetime
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get author info
     *
     * @return array|null
     */
    public function getAuthor();

    /**
     * Set author info
     *
     * @param array|null $author
     * @return \Magenest\Blog\Api\Data\BlogInterface
     */
    public function setAuthor($author);

}
