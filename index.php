<?php

use Framework\Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function (string $class_name) {
    require 'src/' . str_replace('\\', '/', $class_name) . '.php';
});

$router = new Router();

$router->add(
    '/{controller}/{action}'
);
$router->add(
    '/{controller}/{id:\d+}/{action}'
);
$router->add(
    '/home/index',
    array(
        'controller' => 'home',
        'action' => 'index'
    )
);
$router->add(
    '/products',
    array(
        'controller' => 'products',
        'action' => 'index'
    )
);
$router->add(
    '/',
    array(
        'controller' => 'home',
        'action' => 'index'
    )
);

$params = $router->match($path);

if ($params === false) {
    exit('404 Not Found');
}

$action = $params['action'];
$controller = 'App\Controllers\\' . ucwords($params['controller']);

$controller_object = new $controller();

$controller_object->$action();
