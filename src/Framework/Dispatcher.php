<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher
{
    public function __construct(private Router $router)
    {
    }

    public function handle(string $path)
    {
        $params = $this->router->match($path);

        if ($params === false) {
            exit('404 Not Found');
        }

        $action = $params['action'];
        $controller = 'App\Controllers\\' . ucwords($params['controller']);

        if (!class_exists($controller)) {
            exit('404 Controller Not Found');
        }

        if (!method_exists($controller, $action)) {
            exit('404 Action Not Found');
        }

        $controller_object = new $controller();

        $args = $this->getActionArguments($controller, $action, $params);

        $controller_object->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = array();

        $method = new ReflectionMethod($controller, $action);

        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();

            $args[$name] = $params[$name];
        }

        return $args;
    }
}
