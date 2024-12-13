<?php

//Timezone
date_default_timezone_set('America/Sao_Paulo'); 

//Chama todas as models no projeto todo
spl_autoload_register(function ($className) {
    $classPath = '../app/models/' . $className . '.php';

    if (file_exists($classPath)) {
        require_once $classPath;
    }
});

// Chama os Helpers
require_once '../helpers/url_helper.php';
require_once '../helpers/date_helper.php';

// Chama o Router
require_once '../core/Router.php';

$router = new Router();
$router->handleRequest();