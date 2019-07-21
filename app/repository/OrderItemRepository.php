<?php


class OrderItemRepository extends Repository {
	static $tableName = "order_item";

	public static function findByProductAndOrder($product_id, $order_id) {
		return self::singleResultQuery('SELECT order_item.* FROM order_item JOIN orders o ON order_item.order_id = o.id JOIN product On product.id = order_item.product_id WHERE product.id = :product_id AND o.id = :order_id',
			[':product_id'=>$product_id,':order_id'=>$order_id],OrderItem::class);
	}

	/**
	 * loading item of a given order
	 *
	 * @param Integer $orderId
	 * @return Filter <OrderItem>
	 */
	private static function createFilter() {
		return new Filter( [ 
				"code" => " locate(:code,o.code)>0" 
		] );
	}

	private static function createFilterAdmin() {
		$filter = new Filter( [ 
				"code" => " locate(:code,code)>0",
				"u"=>"user_id = :u",
				"q" => " (code like concat('%',:q,'%') OR concat(fname,' ',lname) like concat('%',:q,'%') OR email like concat('%',:q,'%') OR tel like concat('%',:q,'%') OR link like concat('%',:q,'%') OR product_code like concat('%',:q,'%') OR product_name like concat('%',:q,'%') OR site_order_num like concat('%',:q,'%'))",
		] );
		
		$filter->bindArray("site"," site IN (:site)");
		$filter->bindArray("status"," status_id IN (:status)");

		return $filter; 
	}
	
	protected static function createSortAdmin() {
        $sort_id = isset($_REQUEST['sort'])?$_REQUEST['sort']:1;
        switch (abs($sort_id)){
            case 1:
                $sort = 'created';
                break;
            case 2:
                $sort = 'order_status_sort';
                break;
            case 3:
                $sort = 'cargo_price';
                break;
            case 4:
                $sort = 'price';
                break;
            case 5:
                $sort = 'weight';
                break;
            case 6:
                $sort = 'field(order_status_sort,5,3,4)';
                break;
            case 7:
                $sort = 'field(order_status_sort,5,4,3)';
                break;
            case 8:
                $sort = 'field(order_status_sort,5,4,3)';
                break;
            default:
                $sort = 'created';

        }
        $sort .= ' '.(($sort_id<0)?'ASC':'DESC').',created ASC';
        return $sort;
	}
	

	public static function loadByOrder($orderId) {
		return self::select( "order_id = :order_id ORDER BY id DESC", array (
				'order_id' => $orderId 
		) );
	}
	
	public static function updateStatus($orderId,$status_id,$fromStatus=1) {
		 self::executeQuery("update order_item set status = :status WHERE order_id =:order_id AND status = :fromStatus ", array (
				'order_id' => $orderId, 
				'fromStatus' => $fromStatus ,
		 		'status' => $status_id 
		 		 
		) );
	}
	

	static function checkExistingWithLink($link, $orderId) {
		return self::selectOne( "link = :link AND order_id = :order_id limit 1", array (
				":link" => $link,
				':order_id' => $orderId 
		) );
	}

	/**
	 *
	 * @param OrderItem $orderItem        	
	 * @return Model|OrderItem
	 */
	public static function save($orderItem) {
		
		// Insert the values into the database
		self::setTimeZone();
		return parent::insert( [
				'id' => $orderItem->id,
				'currency' => $orderItem->currency,
				'order_id' => $orderItem->order_id,
				'price' => $orderItem->price,
				'product_id' => $orderItem->product_id,
				'product_code' => $orderItem->product_code,
				'product_name' => $orderItem->product_name,
				'qty' => $orderItem->qty,
				'status' => $orderItem->status,
				'weight' => $orderItem->weight, 
				'purchase_price' => $orderItem->purchase_price
		]);
	}

	/**
	 * loading item of a given order
	 *
	 * @param Integer $orderId        	
	 * @return Array <OrderItem>
	 */
	public static function loadByOrderFull($orderId) {
		return self::query('
							  SELECT order_item.*,
							        product.url product_url,
							        product.rnd product_rnd,
							        product.rndurl product_rndurl,
							         round( order_item.price * order_item.qty , 0) AS total_price,
							         round( order_item.price, 0) AS unit_price,
							         order_status.title AS status_title
							    FROM order_item
							         INNER JOIN orders ON order_item.order_id = orders.id
							         INNER JOIN order_status ON order_item.status = order_status.id
                                     LEFT JOIN product ON order_item.product_id = product.id

							   WHERE orders.id = :order_id
							ORDER BY order_item.id DESC				
				', [ 
				":order_id" => $orderId 
		], OrderItem::class );
	}
	
	/**
	 * loading item of a given order
	 *
	 * @param Integer $orderId        	
	 * @return Array <OrderItem>
	 */
	public static function loadByShipmentFull($shipmentId) {
		return self::query('
						  SELECT item.id,
						         o.id order_id,
						         item.created,
						         item.link,
						         item.rnd_img,
						         item.import_price,
						         item.product_code,
						         item.product_name,
						         item.price,
						         item.site,
						         item.status,
						         item.site_order_num,
						         item.selectedvars,
						         item.cargo_price,
						         item.weight,
						         user.fname user_fname,
						         user.lname user_lname,
						         user.tel tel,
						         o.code,
						         item.qty,
						         round(
						              item.price
						            * item.qty
						            * CASE item.currency
						                 WHEN 1 THEN o.value_tl
						                 WHEN 2 THEN o.value_eu
						                 WHEN 3 THEN o.value_us
						              END,
						            0)
						            AS total_price,
				 				round(
						             ( item.price
						            * item.qty
						            * CASE item.currency
						                 WHEN 1 THEN o.value_tl
						                 WHEN 2 THEN o.value_eu
						                 WHEN 3 THEN o.value_us
							                END)
							            + item.import_price,
									0)
						            AS final_price,
						         site.name AS site_name,
						         site.url AS site_url
						    FROM order_item item
                                 INNER JOIN shipment_orderitem ON shipment_orderitem.orderitem_id = item.id
						         INNER JOIN orders o ON item.order_id = o.id
						         INNER JOIN site ON item.site = site.id
						         INNER JOIN user ON o.user = user.id

							   WHERE shipment_orderitem.shipment_id = :shipment_id
							ORDER BY item.id DESC
				', [ 
				":shipment_id" => $shipmentId 
		], OrderItem::class );
	}
	
	public static function loadByShipmentIranFull($shipmentId) {
		return self::query('
						  SELECT item.id,
						         o.id order_id,
						         item.created,
						         item.link,
						         concat(item.id,"_",item.rnd_img) img,
						         item.import_price,
						         item.product_code,
						         item.product_name,
						         item.price,
						         item.site,
						         item.status,
						         item.site_order_num,
						         item.selectedvars,
						         item.cargo_price,
						         item.weight,
						         user.fname user_fname,
						         user.lname user_lname,
						         user.tel tel,
						         o.code,
						         item.qty,
						         round(
						              item.price
						            * item.qty
						            * CASE item.currency
						                 WHEN 1 THEN o.value_tl
						                 WHEN 2 THEN o.value_eu
						                 WHEN 3 THEN o.value_us
						              END,
						            0)
						            AS total_price,
				 				round(
						             ( item.price
						            * item.qty
						            * CASE item.currency
						                 WHEN 1 THEN o.value_tl
						                 WHEN 2 THEN o.value_eu
						                 WHEN 3 THEN o.value_us
							                END)
							            + item.import_price,
									0)
						            AS final_price,
						         site.name AS site_name,
						         site.url AS site_url
						    FROM order_item item
                                 INNER JOIN shipment_iran_orderitem ON shipment_iran_orderitem.orderitem_id = item.id
						         INNER JOIN orders o ON item.order_id = o.id
						         INNER JOIN site ON item.site = site.id
						         INNER JOIN user ON o.user = user.id

							   WHERE shipment_iran_orderitem.shipmentiran_id = :shipment_id
							ORDER BY item.id DESC
				', [
				":shipment_id" => $shipmentId
		], OrderItem::class );
	}


	/**
	 * loading item of a given order to be shown in invoices
	 *
	 * @param Integer $orderId        	
	 * @return  OrderItem[]
	 */
	public static function loadByOrderFullForInvoice($orderId) {
		return self::query('SELECT
  order_item.*,
  product.url                                          AS product_url,
  product.rnd                                          AS product_rnd,
  product.rndurl                                       AS product_rndurl,
  product.price                                        AS product_price,
  product.wholesale_price                              AS product_wholesale_price,
  product.purchase_price                               AS product_purchase_price,
  round(order_item.price, 0)                           AS price,
  round(order_item.price * order_item.qty, 0)          AS total_price,
  round(order_item.weight * order_item.qty, 0)         AS total_weight,
  round(order_item.purchase_price * order_item.qty, 0) AS total_purchase_price

FROM order_item
  INNER JOIN orders ON order_item.order_id = orders.id
  LEFT JOIN product ON order_item.product_id = product.id
WHERE orders.id = :order_id
ORDER BY order_item.id ASC 				
				', [
				':order_id' => $orderId
		], OrderItem::class );
	}

	public static function countItems() {
		$filter = self::createFilterAdmin();
		
		$count = self::query( "select count(*) count FROM (
						    SELECT
						         user.id user_id,
						         user.fname fname,
						         user.lname lname,
						         user.fname user_fname,
						         user.lname user_lname,
						         user.email email,
						         user.tel tel,
                                 item.link,
						         item.product_code,
						         item.product_name,
						         item.status,
						         item.site,
						         item.status status_id,
						         item.site_order_num,
						         o.code code
							  FROM order_item item
							  JOIN orders o ON o.id = item.order_id
							  INNER JOIN user ON o.user = user.id
							 WHERE o.open IS FALSE) res WHERE TRUE " . $filter->filterQuery(), $filter->filterPrepareArray );
		
		return reset( $count[0] ); // gets the first value
	}
	
	
	
	public static function setSiteOrderNum($id,$orderNum) {
		self::executeQuery( "update ".self::getTableName()." set site_order_num = :num where id=:id", [ 
				":id" => $id,
				":num" => $orderNum 
		] );
	}
	
	
	
	public static function loadItems($page) {
		
		
		$filter = self::createFilterAdmin();
	
		$sort = self::createSortAdmin();
	
		$items = self::query( "select * from
						  (SELECT item.id,
						         o.id order_id,
						         item.created,
						         item.buydate,
						         item.link,
						         item.rnd_img,
						         item.import_price,
						         item.product_code,
						         item.product_name,
						         item.price,
						         item.site,
						         item.status,
						         item.status status_id,
						         order_status.sort order_status_sort,
						         item.site_order_num,
						         item.selectedvars,
						         item.cargo_price,
						         item.weight,
						         item.cus_info,
						         user.fname fname,
						         user.lname lname,
						         user.fname user_fname,
						         user.lname user_lname,
						         user.email email,
						         user.tel tel,
						         user.id user_id,
						         o.code,
						         item.qty,
						         round(
						              item.price
						            * item.qty
						            * CASE item.currency
						                 WHEN 1 THEN o.value_tl
						                 WHEN 2 THEN o.value_eu
						                 WHEN 3 THEN o.value_us
						              END,
						            0)
						            AS total_price,
				 				round(
						             ( item.price
						            * item.qty
						            * CASE item.currency
						                 WHEN 1 THEN o.value_tl
						                 WHEN 2 THEN o.value_eu
						                 WHEN 3 THEN o.value_us
							                END)
							            + item.import_price,
									0)
						            AS final_price,
						         site.name AS site_name,
						         site.url AS site_url
						    FROM order_item item
						         INNER JOIN orders o ON item.order_id = o.id
						         INNER JOIN site ON item.site = site.id
						         INNER JOIN user ON o.user = user.id
						         INNER JOIN order_status ON item.status = order_status.id

						   WHERE o.open IS FALSE ) as res
				WHERE TRUE ". $filter->filterQuery()."
						ORDER BY $sort				
						".PageService::query($page) , $filter->filterPrepareArray ,OrderItem::class);
	
		return $items;
	}


    static function SetItemsStatus($shipment_id, $status) {
        self::executeQuery('UPDATE order_item item JOIN shipment_orderitem so ON so.orderitem_id = item.id AND so.shipment_id = :shipment SET item.status= :status',
            [':shipment' => $shipment_id, ':status' => $status]
        );
    }

    static function countWithStatus($status) {
       return self::query('SELECT count(item.id) count FROM order_item item WHERE item.status= :status',
            [':status' => $status], false,true, true
        )['count'];
    }

}
