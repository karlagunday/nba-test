<?php

abstract class Controller {
    public function __construct() {

    }

    public static function load($controller_name) {
        $controller_name = ucfirst($controller_name) . "Controller";
        $path = "classes/controllers/{$controller_name}.php";
        if (!file_exists($path)) {
            return false;
        }

        require_once $path;
        return new $controller_name();
    }
}