<?php


class OrderRepository extends Repository {
	static $tableName = "orders";
	static $final_priceQuery = "coalesce(round((Sum(
round(order_item.price * order_item.qty
, 0)
)+o.pkg_price+o.shipment_price-o.discount+o.extra_price1+o.extra_price2+o.extra_price3), 0), 0) ";



	private static function createFilter() {
		return new Filter([
			"code" => "o.code like concat('%',:code,'%')"
		]);
	}

	private static function createFilterAdmin() {
		$filter = new Filter([
			"search" => " (o.code like concat('%',:search,'%') OR user.fname like concat('%',:search,'%') OR user.lname like concat('%',:search,'%') OR user.email like concat('%',:search,'%') OR user.tel like concat('%',:search,'%'))",
			"u" => "user.id = :u",
			"s" => "o.status = :s",
		]);
		$filter->set('open', 'o.is_open = :open', 0);
		$filter->bind('open', 'o.is_open = :open');

		return $filter;
	}


	protected static function createSortAdmin() {


		$sort = new Sort([
			1 => 'created_at',
			2 => "user_full_name'",
			3 => 'code',
			4 => 'final_price',
			5 => 'total_cash_pay',
			6 => 'order_status_id',

		]);

		return $sort->sortQuery();
	}

	public static function loadCart($user_id) {
        if(!$user_id) {
            throw new Exception("user_id can not be null when you want to load a cart");
        }
        $cart = self::selectOne("user_id = :userid AND is_open IS TRUE Order BY id desc", [':userid' => $user_id]);
        if (!$cart) {
			$cart = new Order();
			$cart->user_id = ($user_id);
			$cart->is_open = true;
			$cart->status = 1;
			//$userGroup = UserGroupRepository::loadByUserId($user_id);
			if (!isset($cart->code)) {
				$key = mt_rand(1, 9);
				for ($i = 0; $i < 2; $i++) {
					$key .= mt_rand(0, 9);
				}
				$key .= mt_rand(1, 9);
				for ($i = 0; $i < 2; $i++) {
					$key .= mt_rand(0, 9);
				}
				$cart->code = $key;
			}
			$cart = self::save($cart);
		}
		return $cart;
	}

	public static function loadBeforeBasket($user_id) {
		$order = self::selectOne("user = :userid AND open IS FALSE Order BY id desc limit 1", array(
			':userid' => $user_id
		));

		return $order;
	}

	public static function save($basket) {
		/* @var $basket Order */
		// Insert the values into the database
		self::setTimeZone();
		return parent::insert([
			'id' => $basket->getId(),
			'user_id' => $basket->user_id,
			'discount' => $basket->discount,
			'code' => $basket->code,
			'is_open' => $basket->is_open,
			"status" => $basket->status,
			"pkg_price" => $basket->pkg_price
		]);
	}

	/**
	 * loading item of a given order
	 *
	 * @param Integer $orderId
	 * @return Array <OrderItem>
	 */
	public static function loadWithTotals($orderId) {
		$final_priceQuery = self::$final_priceQuery;
		return self::query(/** @lang MySQL */
			"SELECT
  o.*,
  o.id,
  $final_priceQuery final_price,

  SUM(order_item.qty)                                         total_qty,
  SUM(order_item.qty * order_item.weight)                     total_weight,
  SUM(order_item.qty * order_item.purchase_price)             total_purchase_price,
  ifnull(SUM(order_item.qty * order_item.price),0)                      total_price
FROM
  orders o
  LEFT JOIN
  (SELECT it.*
   FROM
     order_item it
     INNER JOIN order_item_status ON it.status = order_item_status.id
                                     AND order_item_status.cancel IS FALSE) order_item ON order_item.order_id = o.id

WHERE o.id = :order_id", [
			":order_id" => $orderId
		], Order::class, true, true);
	}

	/**
	 *
	 * @return Order[]
	 */
	public static function loadOrdersForAdmin($page) {
		$limit = $page['limit'];
		$offset = $page['offset'];
		// TODO: more check here in repository level and automating the process

		$filter = self::createFilterAdmin();
		$filterString = $filter->filterQuery();
		$sort = self::createSortAdmin();
		$final_priceQuery = self::$final_priceQuery;


		$query = "SELECT
  o.*,
  concat(user.fname, ' ', user.lname)                    user_full_name,
  user.company                                               user_company,
  user.known_as                                               user_known_as,
  user.tel                                               user_tel,
  user.id                                                user_id,
  $final_priceQuery final_price,
  
  o.status,
  SUM(order_item.qty)                                 total_qty,
  SUM(order_item.qty * order_item.weight)                                 total_weight,
  SUM(order_item.qty * order_item.purchase_price)                                 total_purchase_price,
  SUM(order_item.qty * order_item.price)                                 total_price
FROM orders o
  JOIN user ON o.user_id = user.id
  LEFT JOIN
  (SELECT it.*
   FROM
     order_item it
     INNER JOIN order_item_status ON it.status = order_item_status.id
                                     AND order_item_status.cancel IS FALSE) order_item ON order_item.order_id = o.id

WHERE TRUE AND
$filterString
GROUP BY o.id
ORDER BY $sort
LIMIT $limit OFFSET $offset";

		$orders = self::query($query, $filter->filterPrepareArray, Order::class);

		return $orders;
	}

	/**
	 *
	 * @return Order[]
	 */
	public static function loadOrdersOfUser($page, $user_id) {
		$limit = $page['limit'];
		$offset = $page['offset'];
		// TODO: more check here in repository level and automating the process

		$filter = new Filter([
			"code" => " locate(:code,o.code)>0"
		]);

		$orders = self::query("
						  SELECT o.code,
						         o.id,
						         o.created_at,
						         o.discount,
						         o.value_tl,
						         user.fname user_fname,
						         user.lname user_lname,
								(select SUM(payment.amount) from payment where payment.order_id = o.id and payment.ok is TRUE) payment,
								" . self::$final_priceQuery . " final_price,
							o.status
						    FROM orders o
						         JOIN user ON o.user = user.id
							        LEFT JOIN
							    (SELECT 
							        it.*
							    FROM
							        order_item it
							    INNER JOIN order_status ON it.status = order_status.id
							        AND order_status.cancel IS FALSE) order_item ON order_item.order_id = o.id
				WHERE o.open IS FALSE And o.user = $user_id
						" . $filter->filterQuery() . "
						GROUP BY o.id
						ORDER BY o.status ASC, o.id DESC
						LIMIT " . $limit . " OFFSET " . $offset . "
				", $filter->filterPrepareArray, Order::class);

		return $orders;
	}

	/**
	 *
	 * @return Order[]
	 */
	public static function countOrders() {
		$filter = self::createFilterAdmin();

		$count = self::query("
						  SELECT count(o.id)
						    FROM orders o
								JOIN user ON o.user_id = user.id
						   WHERE TRUE AND " . $filter->filterQuery(), $filter->filterPrepareArray);

		return reset($count[0]);
	}

	public static function countOrdersOfUser($user_id) {
		$filter = self::createFilter();

		$count = self::query("
						  SELECT count(o.id)
						    FROM orders o
						   WHERE o.open IS FALSE AND o.user=" . $user_id . $filter->filterQuery(), $filter->filterPrepareArray);

		return reset($count[0]);
	}

	public static function updateOrderPaid($order_id, $status) {
		self::executeQuery('UPDATE orders o SET o.paid = 1, o.status = :status  WHERE o.id = :id', [
			':id' => $order_id,
			':status' => $status
		]);
	}

	public static function updatePostPlan($order_id, $shipment_id) {

		self::executeQuery("
						  UPDATE orders AS o
						   SET o.shipment_post_plan_id = :shipment_id
						 WHERE id = :id", [
			":id" => $order_id,
			":shipment_id" => $shipment_id
		]);
	}

	public static function updatepkg_price($order_id) {
		$order = self::loadById($order_id);
		if (!$order->post_manual)
			self::executeQuery("
						UPDATE orders AS o
						   SET o.pkg_price =
						          (SELECT coalesce(price,0)
						             FROM pkg_price
						            WHERE (SELECT coalesce(SUM(item.qty * item.weight),0) FROM order_item item JOIN order_item_status ON order_item_status.id = item.status WHERE item.order_id = o.id AND order_item_status.cancel IS FALSE) BETWEEN min AND max
						            LIMIT 1)
						 WHERE o.id = :id;	
				", [
				":id" => $order_id
			]);
	}


	public static function updatePost_price($order_id) {
		$order = self::loadById($order_id);
		if (!$order->post_manual)
			self::executeQuery("
				UPDATE orders AS o
				   SET o.shipment_price =
				          coalesce((SELECT price
				             FROM post_plan_price
				            WHERE     post_plan_id = o.post_plan_id
				                  AND (SELECT coalesce(SUM(qty * weight),0) FROM order_item JOIN order_item_status ON order_item_status.id = order_item.status WHERE order_id = o.id AND order_item_status.cancel IS FALSE) BETWEEN min AND max
				            LIMIT 1),0)
				WHERE o.id = :id;	
				", [
				":id" => $order_id
			]);
	}

	static function updateStatus($order_id, $status_id) {
		parent::executeQuery("UPDATE orders SET status= :status WHERE id = :id", [
			":id" => $order_id,
			":status" => $status_id
		]);

		if ($status_id == 2 || $status_id == 3) {
			//only status 1 goes up
			OrderItemRepository::updateStatus($order_id, 2);
		} else if ($status_id == 1) {
			OrderItemRepository::updateStatus($order_id, 1, 2);
		}
	}

	static function loadByIdAndUser($user_id, $order_id) {
		return parent::selectOne("id = :id AND user_id = :user", [
			":id" => $order_id,
			":user" => $user_id
		]);
	}

	/**
	 * @param unknown $user_id
	 * @param unknown $order_code
	 * @return Order
	 */
	static function loadByCodeAndUser($user_id, $order_code) {
		return parent::selectOne("code = :code AND user = :user", [
			":code" => $order_code,
			":user" => $user_id
		]);
	}

	public static function getSumOrdersOfUser($user_id) {
		$query = "
				SELECT SUM(total.final_price)
				FROM (SELECT " . self::$final_priceQuery . " final_price
						FROM user
						JOIN orders o ON o.user = user.id AND o.open IS FALSE
				        LEFT JOIN
				    (SELECT 
				        it.*
				    FROM
				        order_item it
				    INNER JOIN order_status ON it.status = order_status.id
				        AND order_status.cancel IS FALSE) order_item ON order_item.order_id = o.id
						
				WHERE user.id = :id GROUP BY o.id) AS total
				";
		return self::query($query, [
			":id" => $user_id
		]);
	}

	/**
	 * @param $order Order
	 * @param $address Address
	 */
	public static function updateAddress($order, $address) {
		//$address = AddressService::prepareForJson($address_id);
		self::update($order->id, 'address_id', $address->id);
		self::update($order->id, 'address_city', $address->city);
		self::update($order->id, 'address_detail', $address->detail);
		self::update($order->id, 'address_name', $address->name);
		self::update($order->id, 'address_number', $address->number);
		self::update($order->id, 'address_postalcode', $address->postalcode);
	}

	public static function updateWholesale_price($order_id) {

		self::executeQuery('UPDATE order_item
  JOIN product ON product.id = order_item.product_id
  JOIN orders o ON order_item.order_id = o.id
SET order_item.price = IF(o.is_wholesale, product.wholesale_price, product.price)
WHERE order_item.order_id = :order_id', [':order_id' => $order_id]);

	}
}
