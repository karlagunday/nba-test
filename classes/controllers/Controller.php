<?php

abstract class Controller {
    public function __construct() {

    }

    public static function load($controller_name) {
        $controller_name = ucfirst($controller_name) . "Controller";
        require_once "classes/controllers/{$controller_name}.php";
        return new $controller_name();
    }
}