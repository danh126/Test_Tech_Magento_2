<?php
namespace Magenest\DeliveryTime\Plugin\Checkout;

use Magento\Framework\App\RequestInterface;

class CartAddPlugin
{
    protected $request;

    public function __construct(
        RequestInterface $request
    ) {
        $this->request = $request;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $subject)
    {
        $post = $this->request->getPostValue();

        if (isset($post['delivery_time_option'])) {
            // Thêm dữ liệu vào post để add to cart xử lý
            // Đưa thêm vào request param để dùng tiếp khi thêm quote item
            $this->request->setParam('delivery_time_option', $post['delivery_time_option']);
            if ($post['delivery_time_option'] === 'pick_date' && !empty($post['delivery_date'])) {
                $this->request->setParam('delivery_date', $post['delivery_date']);
            }
        }
    }
}
