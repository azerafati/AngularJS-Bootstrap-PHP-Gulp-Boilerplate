<?php


class Log extends Model {
    public $id;
    public $created;
    public $msg;
    public $level;
    public $user_id;
    public $type;

    function __construct() {
        self::intVal('level');
    }
}
