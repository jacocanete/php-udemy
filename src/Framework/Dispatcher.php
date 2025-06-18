<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher
{
    /**
     * Initializes the Dispatcher with a Router instance for handling route matching.
     */
    public function __construct(private Router $router)
    {
    }

    /**
     * Routes the given HTTP request path to the appropriate controller action and executes it.
     *
     * If the path does not match any route, execution is terminated with a "404 Not Found" message.
     *
     * @param string $path The HTTP request path to dispatch.
     */
    public function handle(string $path)
    {
        $params = $this->router->match($path);

        if ($params === false) {
            exit('404 Not Found');
        }

        $action = $params['action'];
        $controller = 'App\Controllers\\' . ucwords($params['controller']);

        $controller_object = new $controller();

        $args = $this->getActionArguments($controller, $action, $params);

        $controller_object->$action(...$args);
    }

    /**
     * Resolves and returns an array of arguments for a controller action method by matching parameter names to route parameters.
     *
     * @param string $controller The fully qualified controller class name.
     * @param string $action The name of the action method.
     * @param array $params The route parameters to map to method arguments.
     * @return array An associative array of arguments keyed by parameter names for the action method.
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
}
