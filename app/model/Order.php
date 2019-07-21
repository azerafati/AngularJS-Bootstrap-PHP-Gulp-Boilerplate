<?php


class Order extends Model {
	public $id;
	public $user_id;
	public $code;
	public $created_at;
	public $total_price;
	public $discount = 0;
	public $paid = false;
	public $is_open = true;
	public $status = 1;   //1,2,3,4    = waiting for payment, paid in cash, instalment 1, instalment 2
	public $post_plan_id = 3;
	public $pkg_price = 0;
	public $shipment_price = 0;
	public $info;
	public $is_wholesale;
	public $post_manual;
	public $address_detail;
	public $address_name;
	public $address_number;
	public $address_city;
	public $address_postalcode;
	public $orderItems = array ();
	

	function __construct() {
		parent::__construct();
		self::intVal('post_plan_id');
		self::intVal('status');
		self::floatVal('final_price');
		self::floatVal('total_price');
		self::floatVal('discount');
		self::floatVal('shipment_price');
		self::floatVal('pkg_price');
		self::floatVal('pkg_cost');
		self::floatVal('shipment_cost');
		self::boolean('is_wholesale');
		self::boolean('is_open');
		self::floatVal('extra_price1');
		self::floatVal('extra_price2');
		self::floatVal('extra_price3');

	}

	public function getFirstName() {
		return $this->fname;
	}

	public function setFirstName($value) {
		$this->fname = $value;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($value) {
		$this->email = $value;
	}

	public function getLastName() {
		return $this->LastName;
	}

	public function setLastName($value) {
		$this->LastName = $value;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function setOpen($value) {
		$this->open = $value;
	}


	public function isPaid() {
		return $this->paid;
	}

	public function setPaid($value) {
		$this->paid = $value;
	}

	public function getTotalPrice() {
		return $this->total_price;
	}

	public function setTotalPrice($value) {
		$this->total_price = $value;
	}

	public function getCode() {
		//return implode( "-", str_split( $this->code, 3 ) );
		return $this->code;
	}

	public function setCode($value) {
		$this->code = $value;
	}
}
