<?php

spl_autoload_register(function ($className) {
    $classPath = '../app/models/' . $className . '.php';

    if (file_exists($classPath)) {
        require_once $classPath;
    }
});

require_once '../helpers/url_helper.php';
require_once '../helpers/date_helper.php';

require_once '../core/Router.php';

$router = new Router();
$router->handleRequest();