<?php

declare(strict_types=1);

use Framework\Dispatcher;
use Framework\Dotenv;

spl_autoload_register(function (string $class_name) {
    require 'src/' . str_replace('\\', '/', $class_name) . '.php';
});

$dotenv = new Dotenv();

$dotenv->load('.env');

set_error_handler('Framework\ErrorHandler::handleError');

set_exception_handler('Framework\ErrorHandler::handleException');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException('Malformed request URI: ' . $_SERVER['REQUEST_URI']);
}

$router = require 'config/routes.php';

$container = require 'config/services.php';

$dispatcher = new Dispatcher($router, $container);

$dispatcher->handle($path);
