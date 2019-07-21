<?php


class User extends Model {
	public $id;
	public $fname;
	public $lname;
	public $company;
	public $known_as;
	public $email;
	public $tel;
	public $user_group_id;
	public $guest;
	public $admin;
	public $staff;
	public $pass;
	public $pin;
	public $telegram_id;
    public $info;
    public $last_login;
    public $gender = null;
    public $rnd_img = null;

    function __construct() {
    	parent::__construct();
    	self::boolean('guest');
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
		return $this->lname;
	}

	public function setLastName($value) {
		$this->lname = $value;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getName() {
		return self::getFirstName() . " " . self::getLastName();
	}
	public function verifyPassword($password) {
		return password_verify($password, $this->pass);
	}

    public function update_last_login() {
        $last_login = new DateTime($this->last_login);
        $now = new DateTime();
        $interval = ($now->getTimestamp() - $last_login->getTimestamp())/60;
        if ($interval> 1 || $this->last_login ==null) {
            $this->last_login = $now->format('Y-m-d H:i:s');
            UserRepository::update($this->id, 'last_login', $this->last_login);
        }
    }


}
