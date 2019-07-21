<?php


class OrderControllerAdmin {

	static function orderListPage() {
		HtmlControllerAdmin::create()->viewScope([
			"title" => "مدیریت سفارش ها",
			"activeSection" => "order",
			"script" => [
				"order.js?v=2.0.1"
			]
		])->showView('admin/OrdersList');
	}

	static function page() {

		$ordersCount = OrderRepository::countOrders();

		$page = PageService::createPage($ordersCount, 30);

		$orders = OrderRepository::loadOrdersForAdmin($page);

		$content = [];
		foreach ($orders as $order) {
			$content[] = [
				"id" => $order->id,
				"code" => $order->code,
				"created_at" => $order->created_at,
				"discount" => $order->discount,
				"shipment_price" => $order->shipment_price,
				"status" => $order->status,
				"final_price" => $order->final_price,
				"user_full_name" => $order->user_full_name,
                'user_company' => $order->user_company,
                'user_known_as' => $order->user_known_as,
				"user_id" => $order->user_id,
				"user_tel" => $order->user_tel,
				"payment" => $order->payment,
				"is_wholesale" => $order->is_wholesale
			];
		}

		echo PageService::jsonPage($page, $content);
	}

	/**
	 * @param $_req
	 * @param $ctrl RestControllerAdmin
	 */
	static function get($_req, $ctrl) {
		if (isset($_req['id'])) {
			$order = OrderRepository::loadById($_req['id']);
		} else {
			$order = OrderRepository::loadCart($_req['user_id']);
		}
		if (!$order)
			$ctrl->badRequest('ID_INVALID');

		$order = OrderRepository::loadWithTotals($order->id);
		$user = UserRepository::loadById($order->user_id);
		$address_title = AddressRepository::loadProvinceCity($order->address_city);
		/* @var $order Order */
		/* @var $user User */
		$json = [
			"id" => $order->getId(),
			"code" => $order->getCode(),
			"is_wholesale" => $order->is_wholesale,
			"total_qty" => $order->total_qty,
			"total_weight" => $order->total_weight,
			"total_purchase_price" => $order->total_purchase_price,
			"total_price" => $order->total_price,
			"discount" => $order->discount,
			"final_price" => $order->final_price,
			"cost" => $order->cost,
			"profit" => $order->profit,
			"profit_percent" => $order->profit_percent,
			"post_plan" => PostPlanRepository::loadById($order->post_plan_id)->name,
			"pkg_price" => $order->pkg_price,
			"shipment_price" => $order->shipment_price,
			"pkg_cost" => $order->pkg_cost,
			"shipment_cost" => $order->shipment_cost,
			"status" => $order->status,
			"balance" => UserService::getBalance($order->user_id),
			"user_full_name" => $user->getName(),
            'user_company' => $user->company,
            'user_known_as' => $user->known_as,
			"user_id" => $user->id,
			"user_tel" => $user->tel,
			"address_id" => $order->address_id,
			"address_city" =>  $address_title['city'],
			"address_province" => $address_title['province'],
			"address_detail" => $order->address_detail,
			"address_name" => $order->address_name,
			"address_number" => $order->address_number,
			"address_postalcode" => $order->address_postalcode,
			"created_at" => $order->created_at,
			"is_open" => $order->is_open,
			"extra_price1" => $order->extra_price1,
			"extra_price2" => $order->extra_price2,
			"extra_price3" => $order->extra_price3,
            "extra_price1_title" => $order->extra_price1_title,
			"extra_price2_title" => $order->extra_price2_title,
			"extra_price3_title" => $order->extra_price3_title,
			"pkg_price_title" => $order->pkg_price_title,
			"shipment_price_title" => $order->shipment_price_title,
			"order_items" => []
		];


		$basketItems = OrderItemRepository::loadByOrderFullForInvoice($order->id);

		if ($basketItems)
			foreach ($basketItems as $item) {
				/* @var $item OrderItem */
				$item = ( object )$item;
				$json["order_items"][] = array(
					"id" => $item->id,
					"currency" => $item->currency,
					"price" => $item->price,
					"purchase_price" => $item->purchase_price,
					"qty" => intval($item->qty),
					"status" => $item->status,
					"total_price" => $item->total_price,
					"total_weight" => $item->total_weight,
					"total_purchase_price" => $item->total_purchase_price,
					"weight" => $item->weight,
					"product_name" => $item->product_name,
					'product' => [
						"id" => $item->product_id,
						"code" => $item->product_code,
						'name' => $item->product_name,
						'url' => $item->product_url,
						'rnd' => $item->product_rnd,
						'rndurl' => $item->product_rndurl,
						'price' => $item->product_price,
						'wholesale_price' => $item->product_wholesale_price,
					]
				);
			}

		echo json_encode($json);

	}

	static function status() {
		$statuses = OrderStatusRepository::loadAll();
		$res = [];
		foreach ($statuses as $st) {
			$res[$st->id] = $st;
		}
		echo json_encode($res);
	}


	static function statusItem() {
		$statuses = OrderItemStatusRepository::loadAll();
		$res = [];
		foreach ($statuses as $st) {
			$res[$st->id] = $st;
		}
		echo json_encode($res);
	}


	static function orderItemListPage() {
		HtmlControllerAdmin::create()->viewScope([
			"title" => "ریز سفارش ها",
			"activeSection" => "order",
			"script" => [
				"items.js?v=2.1.10"
			]
		])->showView('admin/OrderItemsList');
	}


	/**
	 * @param $_req
	 * @param $ctrl RestControllerAdmin
	 */
	static function edit($_req, $ctrl) {

		if (!isset($_req['ids'])) {
			if (!isset($_req['id'])) {
				$ctrl->badRequest('ID_INVALID');

			} else {
				$ids = [$_req['id']];
			}
		} else {

			$ids = $_req['ids'];
		}
		if (!isset($_req['val']))
			$ctrl->badRequest('VALUE_INVALID');

		$val = $_req['val'];

		if (!isset($_req['property']))
			$ctrl->badRequest('ID_INVALID');
		$property = $_req['property'];


		$actions = [
			'status',
			'discount',
			'shipment_price',
			'shipment_cost',
			'pkg_price',
			'pkg_cost',
			'shipment_pkg',
			'is_wholesale',
			'user_id',
			'created_at',
			'is_open',
			'address',
			'extra_price1',
			'extra_price2',
			'extra_price3',
			'extra_price1_title',
			'extra_price2_title',
			'extra_price3_title',
			'pkg_price_title',
			'shipment_price_title',
		];

		if (in_array($property, $actions)) {
			switch ($property) {
				case 'is_wholesale':
					OrderRepository::update($ids[0], $property, $val);
					OrderRepository::updateWholesale_price($ids[0]);
					break;
				case 'shipment_pkg':
					OrderRepository::updatePost_price($ids[0]);
					OrderRepository::updatepkg_price($ids[0]);
					break;
				case 'address':
					$order = OrderRepository::loadById($ids[0]);
					$address = AddressRepository::loadById($val);
					if ($order && $address)
						OrderRepository::updateAddress($order, $address);
					break;
				default:
					OrderRepository::update($ids[0], $property, $val);
					break;
			}
			if (isset($_req['id']))
				OrderControllerAdmin::get(['id' => $ids[0]], $ctrl);
		} else {
			$ctrl->badRequest('ID_PROPERTY');
		}
	}


	static function closeBasket() {
		RestControllerAdmin::create()->run(function ($user_id, $_req) {
			$basket = OrderRepository::loadCart($_req['user_id']);

			$items = OrderItemRepository::loadByOrder($basket->id);
			if (!empty($items)) {
				OrderRepository::setTimeZone();
				OrderRepository::executeQuery("update orders set open = 0, created = NOW() where id = $basket->id");
			}
		});
	}


	/**
	 * @param $_req
	 * @param $ctrl RestControllerAdmin
	 */
	static function addProduct($_req, $ctrl) {
		if (!isset($_req['id']))
			$ctrl->badRequest('ID_INVALID');

		$id = $_req['id'];
		$order_id = $_req['order_id'];
		$product = ProductRepository::loadById($id);
		$order = OrderRepository::loadById($order_id);
		try {
			OrderService::addItem($product, $order);
			OrderControllerAdmin::get(['id' => $order->id], $ctrl);
		} catch (Exception $e) {
			LoggerAZ::error($e->getMessage(), 'orders');
			$ctrl->badRequest('ERROR');
		}

	}


	/**
	 * @param $_req
	 * @param $ctrl RestControllerAdmin
	 */
	static function addItem($_req, $ctrl) {

		if (!isset($_req['order_id']))
			$ctrl->badRequest('ID_INVALID');

		$order_id = $_req['order_id'];
		$order = OrderRepository::loadById($order_id);
		try {
			$orderItem = new OrderItem();
			$orderItem->order_id = $order->id;
			$orderItem->product_id = null;
			$orderItem->product_code = '';
			$orderItem->product_name = '';
			$orderItem->price = 0;
			$orderItem->weight = 0;
			$orderItem->qty = 1;
			$orderItem->purchase_price = 0;

			OrderItemRepository::save($orderItem);
			OrderControllerAdmin::get(['id' => $order->id], $ctrl);
		} catch (Exception $e) {
			LoggerAZ::error($e->getMessage(), 'orders');
			$ctrl->badRequest('ERROR');
		}
	}


		static function removeItem($user_id, $_req, $ctrl) {

		$item = OrderItemRepository::loadById($_req['id']);
		$order = OrderRepository::loadById($item->order_id);

		if ($item && in_array($order->status, [1, 7])) {
			OrderItemRepository::delete($item->id);
			OrderRepository::updatepkg_price($item->order_id);
			OrderRepository::updatePost_price($item->order_id);
		}


		OrderControllerAdmin::get(['id' => $order->id], $ctrl);
	}


	/**
	 * @param $_req
	 * @param $user_id
	 * @param $ctrl RestControllerAdmin
	 */
	static function editItem($_req, $user_id, $ctrl) {
		if (!isset($_req['val'])) {
			$ctrl->badRequest('WRONG_VALUE');
			LoggerAZ::error('editing OrderItem no value was presented', 'order');
		}
		$id = $_req['id'];
		$val = $_req['val'];
		$actions = [
			'status',
			'qty',
			'price',
			'purchase_price',
			'weight',
			'product_name',
		];
		$property = $_req['property'];
		if (in_array($property, $actions)) {
			$orderItem = OrderItemRepository::loadById($id);
			$order = OrderRepository::loadById($orderItem->order_id);
			OrderItemRepository::update($id, $property, $val);
			if ($property == 'cargo_price') {
				OrderRepository::update($orderItem->order_id, 'cargo_manual', 1);
			}
			OrderControllerAdmin::get(['id' => $order->id], $ctrl);
		} else {
			$ctrl->badRequest('WRONG_PROPERTY');
		}

	}


}
