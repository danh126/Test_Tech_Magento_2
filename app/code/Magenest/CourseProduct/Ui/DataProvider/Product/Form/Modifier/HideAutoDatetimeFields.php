<?php
namespace Magenest\CourseProduct\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class HideAutoDatetimeFields implements ModifierInterface
{
    public function modifyMeta(array $meta)
    {
        // Xóa field tự render của Magento
        unset($meta['product-details']['children']['course_start_datetime']);
        unset($meta['product-details']['children']['course_end_datetime']);
        return $meta;
    }

    public function modifyData(array $data)
    {
        return $data;
    }
}
