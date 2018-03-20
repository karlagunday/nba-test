<?php
# receive a controller and action (method)
$urlParts = explode('/' , $_SERVER['REQUEST_URI']);
$controller = $urlParts[2];
$action = $urlParts[3];

include 'classes/controllers/Controller.php';
// TODO Karl : handle parameters as well

if (isset($controller) && isset($action)) {
    $controller = Controller::load($controller);
    if(method_exists($controller, $action)){
        $result = $controller->$action();
        echo json_encode($result);
    }
}

else{
    echo 'failed';
}