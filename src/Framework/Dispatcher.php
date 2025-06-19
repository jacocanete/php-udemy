<?php

declare(strict_types=1);

namespace Framework;

use ReflectionMethod;
use Framework\Exceptions\PageNotFoundException;

/**
 * Handles routing and dispatching of HTTP requests to controllers and actions.
 */
class Dispatcher
{
    /**
     * Dispatcher constructor.
     *
     * @param Router $router The router instance.
     * @param Container $container The dependency injection container.
     */
    public function __construct(
        private Router $router,
        private Container $container
    ) {
    }

    /**
     * Handles the incoming HTTP request and dispatches to the appropriate controller and action.
     *
     * @param string $path The request path.
     * @return void
     */
    public function handle(string $path)
    {
        $params = $this->router->match($path);

        if ($params === false) {
            throw new PageNotFoundException("404 Not Found '$path'");
        }

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        if (!class_exists($controller)) {
            exit('404 Controller Not Found');
        }

        if (!method_exists($controller, $action)) {
            exit('404 Action Not Found');
        }

        $controller_object = $this->container->get($controller);

        $args = $this->getActionArguments($controller, $action, $params);

        $controller_object->$action(...$args);
    }

    /**
     * Gets the arguments for the action method from the route parameters.
     *
     * @param string $controller The controller class name.
     * @param string $action The action method name.
     * @param array $params The route parameters.
     * @return array The arguments for the action method.
     */
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

    /**
     * Resolves the controller class name from route parameters.
     *
     * @param array $params The route parameters.
     * @return string The fully qualified controller class name.
     */
    private function getControllerName(array $params): string
    {
        $controller = $params['controller'];

        $controller = str_replace('-', '', ucwords(strtolower($controller), '-'));

        $namespace = 'App\Controllers';

        if (array_key_exists('namespace', $params)) {
            $namespace .= '\\' . $params['namespace'];
        }

        return $namespace . '\\' . $controller;
    }

    /**
     * Resolves the action method name from route parameters.
     *
     * @param array $params The route parameters.
     * @return string The action method name.
     */
    private function getActionName(array $params): string
    {
        $action = $params['action'];

        $action = lcfirst(str_replace('-', '', ucwords(strtolower($action), '-')));

        return $action;
    }
}
