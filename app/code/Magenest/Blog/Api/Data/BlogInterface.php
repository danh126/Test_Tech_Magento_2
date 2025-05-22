<?php
namespace Magenest\Blog\Api\Data;

interface BlogInterface
{
    public function getId();
    public function setId($id);

    public function getTitle();
    public function setTitle($title);

    public function getContent();
    public function setContent($content);

    public function getUrlRewrite();
    public function setUrlRewrite($url);

    public function getAuthorId();
    public function setAuthorId($authorId);

    public function getStatus();
    public function setStatus($status);

    public function getDescription();
    public function setDescription($desc);

    public function getCreatedAt();
    public function setCreatedAt($createdAt);

    public function getUpdatedAt();
    public function setUpdatedAt($updatedAt);
}
