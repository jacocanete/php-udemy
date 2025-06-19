<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Dispatcher;
use Framework\Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function (string $class_name) {
    require 'src/' . str_replace('\\', '/', $class_name) . '.php';
});

$router = new Router();

$router->add(
    '/admin/{controller}/{action}',
    array(
        'namespace' => 'Admin'
    )
);
$router->add(
    '/{title}/{id:\d+}/{page:\d+}',
    array(
        'controller' => 'products',
        'action' => 'showPage'
    )
);
$router->add(
    '/product/{id:[\w-]+}',
    array(
        'controller' => 'products',
        'action' => 'show'
    )
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
$router->add(
    '/{controller}/{action}'
);

$dispatcher = new Dispatcher($router);

$dispatcher->handle($path);
