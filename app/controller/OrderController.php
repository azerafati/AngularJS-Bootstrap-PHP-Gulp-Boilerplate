<?php


class OrderController {

	static function removeOrder() {
		RestController::create()->run(function ($_req, $user_id) {
			$order = OrderRepository::loadByIdAndUser($user_id, $_req['id']);
			if (empty($order)) {
				Util::badReq();
			}
			if ($order->status != 1) {
				Util::badReq();
			}
			PaymentRepository::executeQuery('DELETE FROM payment WHERE order_id = :order AND (income = 3 OR (income = 1 AND ok IS FALSE))', [':order' => $order->id]);
			OrderRepository::delete($order->id);
		});
	}

	static function updateItemInfo() {
		RestController::create()->run(function ($_req, $user_id) {
			$order = OrderRepository::loadByIdAndUser($user_id, $_req['oid']);
			if (empty($order)) {
				Util::badReq();
			}
			if ($order->status > 2) {
				Util::badReq();
			}
			$item = OrderItemRepository::loadById($_req['id']);
			if (!$item || $item->order_id != $order->id || $item->status > 2) {
				Util::badReq();
			}
			OrderItemRepository::update($item->id, 'cus_info', isset($_req['val']) ? $_req['val'] : '');
		});
	}


	static function userOrdersPage() {
		HtmlController::create()->viewScope(["title" => "سفارش ها",
			"script" => ["order.js?v=2.0.1"]])
			->showView('UserOrders');
	}


	static function closeBasket($user_id, $_req) {
		$basket = OrderRepository::loadCart($user_id);
		$items = OrderItemRepository::loadByOrder($basket->id);
		if (!empty($items)) {
			OrderRepository::setTimeZone();
			OrderRepository::executeQuery("update orders set open = 0, created = NOW() where id = $basket->id");
		}
		if (checkSet($_req, 'adrs', false)) {
			$address = AddressRepository::loadByIdAndUser($_req['adrs'], $user_id);
			if ($address) {
				OrderRepository::updateAddress($basket, $address);
			}
		}
	}

	/**
	 * @param $_req
	 * @param $user_id
	 * @param $ctrl RestController
	 */
	static function addToCart($_req, $user_id, $ctrl) {
		/* @var $product Product */
		if (!isset($_req['rid'])) {
			if (!isset($_req['code'])) {
				$ctrl->badRequest('WRONG_CODE');
			} else {
				$product = ProductRepository::loadByCode($_req['code']);
			}
		} else {
			$product = ProductRepository::loadByRId($_req['rid']);
		}
		if (!$product) {
			$ctrl->badRequest('WRONG_ID');
		}
		$order = OrderRepository::loadCart($user_id);

		try {
			OrderService::addItem($product, $order, checkSet($_req, 'qty', 1));
			echo json_encode(['result'=>'OK']);
		} catch (Exception $e) {
			$ctrl->badRequest('ERROR');
		}
	}

	static function cart($user_id) {
		//sleep(2);
		$cart = OrderRepository::loadCart($user_id);
		$cart = OrderService::getOrderJson($cart);
		echo json_encode($cart);
	}

	static function setPostPlan($_req, $user_id) {
		if (!checkSet($_req, 'id', false)) {
			Util::badReq('INVALID_ID');
		}
		$plan = PostPlanRepository::loadById($_req['id']);
		if (!$plan) {
			Util::badReq('INVALID_ID');
		}
		$basket = OrderRepository::loadCart($user_id);
		OrderRepository::update($basket->id, 'post_plan_id', $plan->id);
		OrderRepository::updatePost_price($basket->id);
		OrderRepository::updatepkg_price($basket->id);

	}

	static function setQty($_req, $user_id) {
		if (!checkSet($_req, 'id', false)) {
			Util::badReq('INVALID_ID');
		}
		$basket = OrderRepository::loadCart($user_id);
		$item = OrderItemRepository::selectOne('id= :id AND order_id = :basket', [':id' => $_req['id'],
			':basket' => $basket->id]);
		if (!$item) {
			Util::badReq('INVALID_ID');
		}
		OrderItemRepository::update($item->id, 'qty', checkSet($_req, 'qty', 1));
		OrderRepository::updatePost_price($basket->id);
		OrderRepository::updatepkg_price($basket->id);
	}

	public static function basketPage() {
		$controller = HtmlController::create();
		$controller->viewScope(["title" => "سبد خرید",
			"script" => ["basketPage.js?v=2.0.7",]])->showView("basketPage");
	}

	static function getAll($_req, $user_id) {
		$ordersCount = OrderRepository::countOrdersOfUser($user_id);

		$page = PageService::createPage($ordersCount);

		$orders = OrderRepository::loadOrdersOfUser($page, $user_id);

		$content = [];
		foreach ($orders as $order) {
			$content[] = [
				"id" => $order->id,
				"code" => $order->getCode(),
				"created" => $order->created,
				"discount" => $order->discount,
				"shipment_price" => $order->shipment_price,
				"status" => $order->status,
				"final_price" => $order->final_price,
				"value_tl" => $order->value_tl,
				"payment" => $order->payment ?: 0
			];
		}

		$data = [
			"orders" => $content,
			"statuses" => OrderStatusRepository::loadAllPaymentStatus(),
			"balance" => UserService::getBalance($user_id)
		];

		echo PageService::jsonPage($page, $data);
	}

	static function get($_req, $user_id, $ctrl) {

		$order = OrderRepository::loadByIdAndUser($user_id, $_req['id']);

		if (!$order)
			$ctrl->badRequest('WRONG_ID');
		echo json_encode(OrderService::getOrderJson($order));
	}


	static function removeItem($_req, $user_id) {

		if (!$user_id) {
			Util::badReq();
		}
		if (!(isset($_POST['id']))) {
			Util::badReq();
		}
		$basket = OrderRepository::loadCart($user_id);

		// find or create a basket
		$query = "DELETE item FROM order_item AS item
			  WHERE item.id = :id AND item.order_id = :basket";

		Repository::executeQuery($query, [":id" => $_POST['id'], ":basket" => $basket->id]);

		OrderRepository::updatepkg_price($basket->id);
		OrderRepository::updatePost_price($basket->id);

		echo json_encode(OrderService::getOrderJson(OrderRepository::loadCart($user_id)));

	}


	/**
	 * @param $_req array
	 * @param $user_id
	 * @param $ctrl RestController
	 */
	static function editItem($_req, $user_id, $ctrl) {

		if (!$user_id) {
			$ctrl->badRequest('WRONG_USER_ID');
		}
		if (isset($_req['id']) && $_req['id']) {
			$item = OrderItemRepository::loadById($_req['id']);
		} else {
			$ctrl->badRequest('NO_ID');
		}
		if (!$item) {
			$ctrl->badRequest('WRONG_ID');
		}
		$order = OrderRepository::loadByIdAndUser($user_id, $item->order_id);
		if (!$order) {
			$ctrl->badRequest('WRONG_ORDER');
		}
		if ($order->status > 1) {
			$ctrl->badRequest('ORDER_READONLY');
		}

		$property = $_req['property'];
		if (!isset($_req['val'])) {
			$ctrl->badRequest('NO_VALUE');
		}
		$actions = ['qty'];
		if (in_array($property, $actions)) {
			$val = $_req['val'];

			switch ($property) {

				case 'qty':
					OrderItemRepository::update($item->id, $property, $val);
					break;
				default:
					OrderItemRepository::update($item->id, $property, $val);
					break;
			}

		} else {
			Util::badReq('ERROR');
		}
//		OrderRepository::updatePost_price($order->id);
//		OrderRepository::updatepkg_price($order->id);
		self::get(['id' => $order->id], $user_id, $ctrl);


	}


}
