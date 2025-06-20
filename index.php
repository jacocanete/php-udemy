<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Dispatcher;
use Framework\Router;
use Framework\Container;
use App\Database;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException('Malformed request URI: ' . $_SERVER['REQUEST_URI']);
}

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

$container = new Container();

$container->set(Database::class, function () {
    return new Database(
        'localhost',
        'product_db',
        'product_db_user',
        'secret'
    );
});

$dispatcher = new Dispatcher($router, $container);

$dispatcher->handle($path);
