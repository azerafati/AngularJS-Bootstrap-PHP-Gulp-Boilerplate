<?php

class LoggerAZ {
	
	static private function log($msg,$level,$type) {
		$log = new Log();
		$log->level = $level;
		$log->msg = $msg;
		$log->user_id = UserService::currentUserId() ?  : null;
		$log->type = $type;
		LogRepository::save( $log );
	}

	static public function debug($msg, $type = null) {
		self::log( $msg, 1, $type );
	}

	static public function info($msg, $type = null) {
		self::log( $msg, 2, $type );
	}

	static public function warning($msg, $type = null) {
		self::log( $msg, 3, $type );
	}

	static public function error($msg, $type = null) {
		self::log( $msg, 4, $type );
	}

	static public function fatal($msg, $type = null) {
		self::log( $msg, 5, $type );
	}
}