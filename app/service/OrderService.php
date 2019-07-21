<?php


class OrderService {

    /**
     * prepare a json for view from basket
     *
     * @param Order $order
     * @return Order
     */
    static function getOrderJson($order) {
        $order = OrderRepository::loadWithTotals($order->id);

        $json = [
            "id" => $order->id,
            "code" => $order->code,
            "total_price" => $order->total_price,
            "final_price" => $order->final_price,
            "discount" => $order->discount,
            "post_plan_id" => $order->post_plan_id,
            "shipment_price" => $order->shipment_price,
            "pkg_price" => $order->pkg_price,
            "orderItems" => [],
            //"balance" => UserService::getBalance($cart->user)
        ];

        $basketItems = OrderItemRepository::loadByOrderFull($order->id);

        if ($basketItems)
            foreach ($basketItems as $item) {
                /* @var $item OrderItem */
                $item = ( object )$item;
                $json['orderItems'][] = [
                    'id' => $item->id,
                    'currency' => $item->currency,
                    'product' => [

                        'price' => $item->price,
                        'id' => $item->product_id,
                        'code' => $item->product_code,
                        'name' => $item->product_name,
                        'url' => $item->product_url,
                        'rnd' => $item->product_rnd,
                        'rndurl' => $item->product_rndurl

                    ],
                    'qty' => intval($item->qty),
                    'status' => $item->status_title,
                    'total_price' => $item->total_price,
                    'weight' => $item->weight,
                    'cus_info' => $item->cus_info
                ];
            }


        return ($json);
    }


    /**
     * @param $product Product
     * @param $qty
     * @param $order Order
     * @return OrderItem
     * @throws Exception
     */
    static function addItem($product, $order, $qty = 1) {
        $orderItem = OrderItemRepository::findByProductAndOrder($product->id, $order->id);
        if ($orderItem) {
            OrderItemRepository::update($orderItem->id, 'qty', $orderItem->qty + 1);
        } else {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->id;
            $orderItem->product_code = $product->code;
            $orderItem->product_name = $product->name;
            if ($order->is_wholesale) {
                $orderItem->price = $product->wholesale_price;
                if ($orderItem->price == 0) {
                    $orderItem->price = $product->price;
                }
            } else {
                $orderItem->price = $product->price;
            }
            $orderItem->weight = $product->weight;
            $orderItem->qty = $qty;
            $orderItem->purchase_price = $product->purchase_price;

            if ($orderItem->price < 2)
                throw new Exception('the item seems not to be correct price is ' . $orderItem->price);

            OrderItemRepository::save($orderItem);
        }
        if ($order->status == 1) {
//            OrderRepository::updatePost_price($order->id);
//            OrderRepository::updatepkg_price($order->id);
        }

        return $orderItem;
    }

}