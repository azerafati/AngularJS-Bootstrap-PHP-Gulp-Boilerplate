<?php


class OrderItem extends Model {
	
	public $id;
	public $product_id;
	public $product_name;
	public $product_code;
	public $price = 0;
    public $total_price = 0;
	public $qty =1;
	public $status= 1;
	public $currency = 'IRT';
	public $weight = 0;
	public $order_id;
	public $created;
	public $cus_info;
	public $purchase_price;

	function __construct() {
		parent::__construct();
		self::intVal('qty');
		self::intVal('status');
		self::floatVal('price');
		self::floatVal('purchase_price');
		self::floatVal('total_price');
		self::floatVal('total_weight');
		self::floatVal('total_purchase_price');
		self::floatVal('weight');
	}
	

}
