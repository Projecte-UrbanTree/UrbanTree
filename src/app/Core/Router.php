<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    public function load($file)
    {
        $routes = include $file;
        $this->routes = $routes;
    }

    public function dispatch($requestMethod, $requestUri)
    {
        // Check for direct match first
        if (isset($this->routes[$requestMethod][$requestUri])) {
            return $this->callRoute($this->routes[$requestMethod][$requestUri]);
        }

        // If no direct match, check for dynamic routes with parameters
        foreach ($this->routes[$requestMethod] as $route => $routeInfo) {
            $routePattern = preg_replace('/:\w+/', '(\w+)', $route);
            $pattern = '#^' . $routePattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Remove the full match
                $params = $this->extractParams($route, $matches);
                return $this->callRoute($routeInfo, $params);
            }
        }

        echo "404 Not Found";
    }

    protected function extractParams($route, $matches)
    {
        preg_match_all('/:(\w+)/', $route, $paramNames);
        return array_combine($paramNames[1], $matches);
    }

    protected function callRoute($routeInfo, $params = [])
    {
        $controller = new $routeInfo['controller']();
        $method = $routeInfo['method'];
        $controller->$method(...array_values($params));
    }
}
