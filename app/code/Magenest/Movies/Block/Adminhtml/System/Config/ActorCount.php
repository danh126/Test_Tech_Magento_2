<?php

namespace Magenest\Movies\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\App\ResourceConnection;
use Magento\Backend\Block\Template\Context;

class ActorCount extends Field
{
    protected $resource;

    public function __construct(
        Context $context,
        ResourceConnection $resource,
        array $data = []
    ) {
        $this->resource = $resource;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('magenest_actor');
        $count = $connection->fetchOne("SELECT COUNT(*) FROM $tableName");

        return '<div>' . $count . ' rows</div>';
    }
}
