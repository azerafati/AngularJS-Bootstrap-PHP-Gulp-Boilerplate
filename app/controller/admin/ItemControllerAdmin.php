<?php class ItemControllerAdmin {

    static function setStatus($_req, $user_id) {
        $orderItem = OrderItemRepository::loadById($_req['id']);
        $order = OrderRepository::loadById($orderItem->order_id);
        $agency_id = $order->agency_id;
        EventService::start($agency_id);
        $oldVal = $orderItem->status;

        OrderStatusRepository::updateItemStatus($_req['id'], $_req['status']);
        if ($_req['status'] == 3) {
            OrderItemRepository::update($_req['id'], 'buydate', date('Y-m-d H:i:s'));
        }
        if ($_req['status'] == 3) {
            OrderItemRepository::update($_req['id'], 'buydate', date('Y-m-d H:i:s'));
        }
        if ($_req['status'] == 3) {
            OrderItemRepository::update($_req['id'], 'buydate', date('Y-m-d H:i:s'));
        }


        $item = OrderItemRepository::loadById($_req['id']);
        OrderRepository::updatepkg_price($item->order_id);
        OrderRepository::updatePost_price($item->order_id);

        //EventService::editItem($agency_id, $user_id, $order, $orderItem, 'status', $oldVal, $_req['status']);
    }


    static function edit($_req, $user_id) {
        if (!isset($_req['val'])) {
            Util::badReq();
        }
        $id = $_req['id'];
        $val = $_req['val'];
        $actions = [
            "cargo_price",
            'import_price',
            "weight",
            'price',
            'qty',
            'cus_info',
            'site_order_num',
            'currency',
            'product_name',
        ];
        $property = $_req['property'];
        if (in_array($property, $actions)) {
            $orderItem = OrderItemRepository::loadById($id);
            $order = OrderRepository::loadById($orderItem->order_id);
            $agency_id = $order->agency_id;
            EventService::start($agency_id);
            $oldVal = $orderItem->{$property};
            OrderItemRepository::update($id, $property, $val);
            if (in_array($property, ['cargo_price', 'weight', 'price', 'qty',])) {
                OrderRepository::updatepkg_price($orderItem->order_id);
                OrderRepository::updatePost_price($orderItem->order_id);
            }
            if ($property == 'cargo_price') {
                OrderRepository::update($orderItem->order_id, 'cargo_manual', 1);
            }
            EventService::editItem($agency_id, $user_id, $order, $orderItem, $property, $oldVal, $val);

        } else {
            Util::badReq();
        }
    }
}
