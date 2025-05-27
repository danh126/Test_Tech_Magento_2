<?php
namespace Magenest\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;
use Magenest\Blog\Model\BlogFactory;

class View extends Template
{
    protected $request;
    protected $blogFactory;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        BlogFactory $blogFactory,
        array $data = []
    ) {
        $this->request = $request;
        $this->blogFactory = $blogFactory;
        parent::__construct($context, $data);
    }

    public function getBlog()
    {
        $id = $this->request->getParam('id');
        return $this->blogFactory->create()->load($id);
    }
}
