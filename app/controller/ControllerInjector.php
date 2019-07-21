<?php

/**
 * Basic controller Injector Management trying to keep it simple and fast
 *
 *
 * @author Alireza Zerafati (bludream@gmail.com)
 *
 */


class ControllerInjector {

    private $injectionParams = [ ];



    public function getInjects($function, &$controller){
        if (is_string($function)) {
            $class = explode('::', $function)[0];
            $action = explode('::', $function)[1];
            $method = (new ReflectionClass($class))->getMethod($action);
        } else {
            $method = new ReflectionFunction($function);
        }

        $params = [ ];
        foreach ( $method->getParameters() as $index => $param ) {
            switch ($param->name) {
                case 'user_id' :
                    $params[$index] = UserService::currentUserId();
                    break;

                case '_req' :
                    $params[$index] = $_REQUEST?:json_decode( file_get_contents( 'php://input' ), true );
                    break;
                case 'ctrl' :
                    $params[$index] = $controller;
                    break;
                default:
                    $params[$index] = null;

            }

        }

        return $params;
    }


    function __construct() {



    }
}

