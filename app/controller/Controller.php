<?php

/**
 * Base controller class to implement the common task andd exception handling
 * 
 * 
 * @author Alireza Zerafati (bludream@gmail.com)
 *
 */


class Controller {

	protected $injector;
	protected $setting;
	protected $debug;
	/**
	 * @return Controller
	 */
	static function create() {
		$class = get_called_class ();
		$controller = new $class ();
		
		return $controller;
	}

	function run($function) {
		try {
			// finally running the controller function after all initializers

            $params = $this->injector->getInjects($function,$this);
			$params['$ctrl'] = &$this;
			header_remove('server');
			header_remove('x-powered-by');
			header_remove('x-turbo-charged-by');
			call_user_func_array($function, $params);
			exit ();
		} catch ( Exception $e ) {
			if($this->debug)echo $e->getMessage () . "\n" ." --file:" . $e->getFile()." ---line:".$e->getLine ().$e->getTraceAsString() ;
			LoggerAZ::error('error in controller = '.$e);
			self::badRequest ();
		}
	}

	function badRequest($msg = "") {
		http_response_code( 400 );
		echo json_encode(['err' => $msg]);
		exit();
	}
	
	function redirect($url,$permanent=false) {
			header( 'Location: ' . $url, true, ($permanent) ? 301 : 302 );
	}

	function authorize($userGroups) {
		if (! UserService::authorize( $userGroups )){
			http_response_code(405);
			exit ();
		}
		return $this;
	}

	function accept($supportedRequestMethods) {
		if (! in_array ( $_SERVER ['REQUEST_METHOD'], $supportedRequestMethods )) {
			self::badRequest ();
		}
		return $this;
	}

	function __construct() {
		
		if (! $settings = parse_ini_file ( constant ( 'AppRoot' ) . 'config.ini', true ))
			throw new exception ( 'Unable to open config.ini.' );
		
		if ($settings ['Application'] ['debug']) {
			ini_set('error_reporting', E_ALL);
			ini_set('display_errors', 'On');  //On or Off
		}
		
		$this->debug = $settings ['Application'] ['debug'];
		$this->setting = $settings;
		//instantiate injector
		$this->injector = new ControllerInjector();
	}



}

