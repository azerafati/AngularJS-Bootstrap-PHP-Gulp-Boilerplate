<?php


class OrderItemStatus extends Model {
    public $id;
    public $title;
    public $color;
    public $sort;
    public $cancel;

    function __construct() {
        parent::__construct();
    }

}
