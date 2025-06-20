<?php

declare(strict_types=1);

namespace Framework;

/**
 * Handles route registration and matching for HTTP requests.
 */
class Router
{
    /**
     * List of registered routes.
     *
     * @var array<int, array{path: string, params: array}>
     */
    private array $routes = array();

    /**
     * Adds a new route to the router.
     *
     * @param string $path The route path pattern.
     * @param array $params Optional parameters for the route (controller, action, etc).
     * @return void
     */
    public function add(string $path, array $params = array()): void
    {
        $this->routes[] = array(
            'path' => $path,
            'params' => $params
        );
    }

    /**
     * Matches a request path to a registered route.
     *
     * @param string $path The request path.
     * @return array|bool The matched route parameters or false if no match.
     */
    public function match(string $path): array|bool
    {
        $path = urldecode($path);

        $path = trim($path, '/');

        foreach ($this->routes as $route) {
            $pattern = $this->getPatternFromRoutePath($route['path']);

            if (preg_match($pattern, $path, $matches)) {
                $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $params = array_merge($matches, $route['params']);

                return $params;
            }
        }

        return false;
    }

    /**
     * Converts a route path to a regex pattern for matching.
     *
     * @param string $route_path The route path pattern.
     * @return string The regex pattern for matching the route.
     */
    private function getPatternFromRoutePath(string $route_path): string
    {
        $route_path = trim($route_path, '/');

        $segments = explode('/', $route_path);

        $segments = array_map(function (string $segment): string {
            if (preg_match('#^\{([a-z][a-z0-9]*)\}$#', $segment, $matches)) {
                return '(?<' . $matches[1] . '>[^/]+)';
            }

            if (preg_match('#^\{([a-z][a-z0-9]*):(.+)\}$#', $segment, $matches)) {
                return '(?<' . $matches[1] . '>' . $matches[2] . ')';
            }

            return $segment;
        }, $segments);

        return '#^' . implode('/', $segments) . '$#iu';
    }
}
