<?php

class Router {
    public function handleRequest() {
        $controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'HomeController';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        require_once "../app/controllers/$controllerName.php";
        $controller = new $controllerName();
        $controller->$action();
    }
}