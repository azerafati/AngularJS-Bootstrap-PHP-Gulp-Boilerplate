<?php


class Product extends Model {

	public $id;
	public $url;
	public $name;
	public $info;
	public $seodesc;
	public $hidden;
	public $active;
	public $rnd;
	public $created;
	public $sort;
	public $price;
	public $wholesale_price;
	public $old_price;
	public $weight;
	public $rndurl;
	public $code;
	public $imgs;
	public $stock;
	public $view_count;
	public $purchase_price;

	function __construct() {
		parent::__construct();
		self::intVal('imgs');
		self::floatVal('wholesale_price');
		self::floatVal('purchase_price');
		self::floatVal('old_price');
		self::boolean('hidden');

	}

	function getLink() {
		return '/p' . $this->rndurl . '/' . $this->url;
	}

	public function getImage($num=0, $zoom=false) {

		if ($this->imgs < 1) {
			return false;
		}
		return '/res/img/prod/' . $this->rnd . '/' . $this->url . ($num > 0 ? '-' . $num : ($zoom ? '-' : '')) . ($zoom ? 'z' : '') . '.jpg';
	}

}
