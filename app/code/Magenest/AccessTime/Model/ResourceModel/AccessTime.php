<?php
namespace Magenest\AccessTime\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AccessTime extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_access_time', 'entity_id');
    }

    public function getAccessTimeDataByProductId($productId)
    {
        $connection = $this->getConnection();
        $table = $this->getMainTable();

        $select = $connection->select()
            ->from($table, ['customer_group_id', 'access_time_days'])
            ->where('product_id = ?', $productId);

        $rows = $connection->fetchAll($select);

        $result = [];
        foreach ($rows as $row) {
            $result[$row['customer_group_id']] = (int)$row['access_time_days'];
        }
        return $result;
    }

    public function saveAccessTimeData($productId, array $data)
    {
        $connection = $this->getConnection();
        $table = $this->getMainTable();

        // Xóa dữ liệu cũ
        $connection->delete($table, ['product_id = ?' => $productId]);

        // Insert dữ liệu mới
        foreach ($data as $groupId => $days) {
            $connection->insert($table, [
                'product_id' => $productId,
                'customer_group_id' => $groupId,
                'access_time_days' => $days
            ]);
        }
    }
}
