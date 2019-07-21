<?php


class Category extends Model {
	public $id;
	public $url;
	public $title;
	public $img;
	public $parent;
	public $hidden;
	public $info;
	public $seodesc;

	function __construct() {
    	parent::__construct();

    }

	public function getLink() {
		return '/c'.$this->id.'/'.$this->url;

	}


}
