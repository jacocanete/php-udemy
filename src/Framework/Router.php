<?php

namespace Framework;

class Router
{
    private array $routes = array();

    /**
     * Registers a new route with an optional set of parameters.
     *
     * @param string $path The route path pattern to add.
     * @param array $params Optional parameters associated with the route.
     */
    public function add(string $path, array $params = array()): void
    {
        $this->routes[] = array(
            'path' => $path,
            'params' => $params
        );
    }

    /**
     * Attempts to match the given URL path against registered routes.
     *
     * Decodes and normalizes the input path, then checks each stored route using a generated regex pattern. If a match is found, returns an array of extracted named parameters merged with the route's predefined parameters. Returns false if no route matches.
     *
     * @param string $path The URL path to match.
     * @return array|bool An array of matched parameters if a route matches, or false if no match is found.
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
     * Converts a route path with parameter placeholders into a regular expression pattern for matching URLs.
     *
     * Supports placeholders in the form `{name}` for any non-slash value and `{name:regex}` for custom regex constraints.
     *
     * @param string $route_path The route path containing optional parameter placeholders.
     * @return string The generated regular expression pattern.
     */
    private function getPatternFromRoutePath(string $route_path): string
    {
        $route_path = trim($route_path, '/');

        $segments = explode('/', $route_path);


        $segments = array_map(function (string $segment): string {
            if (preg_match('#^\{([a-z][a-z0-9]*)\}$#', $segment, $matches)) {
                return '(?<' . $matches[1] . '>[^/]*)';
            }

            if (preg_match('#^\{([a-z][a-z0-9]*):(.+)\}$#', $segment, $matches)) {
                return '(?<' . $matches[1] . '>' . $matches[2] . ')';
            }

            return $segment;
        }, $segments);

        return '#^' . implode('/', $segments) . '$#iu';
    }
}
