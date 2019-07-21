<?php

spl_autoload_register ( 'MyAutoloader::ControllerLoader' );
spl_autoload_register ( 'MyAutoloader::ViewLoader' );
spl_autoload_register ( 'MyAutoloader::ServiceLoader' );
spl_autoload_register ( 'MyAutoloader::ModelLoader' );
spl_autoload_register ( 'MyAutoloader::RepositoryLoader' );
spl_autoload_register ( 'MyAutoloader::LibsLoader' );

define('AppRoot', __DIR__.'/' );
class MyAutoloader {
	public static function ServiceLoader($className) {
		$filename = AppRoot . "service/" . $className . ".php";
		if (file_exists ( $filename )) {
			include ($filename);
			return (class_exists ( $className, false ) || interface_exists ( $className, false ));
		}
		return false;
	}
	public static function ModelLoader($className) {
		$filename = AppRoot . "model/" . $className . ".php";
		return self::check($filename, $className);
	}
	public static function RepositoryLoader($className) {
		$filename = AppRoot . "repository/" . $className . ".php";
		return self::check($filename, $className);
	}
	
	public static function ControllerLoader($className) {
		$filename = AppRoot . "controller/" . $className . ".php";
		if (self::check($filename, $className)) {
			return true;
		} else {
			$filename = AppRoot . "controller/admin/" . $className . ".php";
			return self::check($filename, $className);
		}
	}
	public static function ViewLoader($className) {
		$filename = AppRoot . "view/" . $className . ".php";
		return self::check($filename, $className);
	}
	
	public static function LibsLoader($className) {
		$filename = AppRoot . "libs/" . $className . ".php";
		return self::check($filename, $className);
	}
	
	private static function check($filename,$className) {
		if (file_exists ( $filename )) {
			include ($filename);
			return (class_exists ( $className, false ));
		}
		return false;
	}
	
}

function checkSet($array, $var, $instead=null) {
    if (isset($array[$var])) {
        return $array[$var];
    } else {
        return $instead;
    }
}