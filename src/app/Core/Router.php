<?php

namespace App\Core;

use App\Middlewares\MiddlewareInterface;
use Exception;

class Router
{
    protected const HTTP_METHODS = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

    protected array $routes = [];

    public function load(string $file): void
    {
        $this->routes = include $file;
    }

    public function dispatch(string $requestMethod, string $requestUri, array $postData = []): void
    {
        if (! in_array($requestMethod, self::HTTP_METHODS)) {
            $this->abort(405, 'Method Not Allowed');

            return;
        }

        // Match exact route
        if (isset($this->routes[$requestMethod][$requestUri])) {
            $this->callRoute($this->routes[$requestMethod][$requestUri], $requestMethod === 'POST' ? ['postData' => $postData] : []);

            return;
        }

        // Match dynamic route with parameters
        foreach ($this->routes[$requestMethod] as $route => $routeInfo) {
            $routePattern = preg_replace('/:\w+/', '([^/]+)', $route);
            if (preg_match("#^{$routePattern}$#", $requestUri, $matches)) {
                array_shift($matches);
                $params = $this->extractParams($route, $matches);
                $arguments = $requestMethod === 'POST' ? array_merge($params, ['postData' => $postData]) : $params;

                $this->callRoute($routeInfo, $arguments);

                return;
            }
        }

        $this->abort(404, 'Not Found');
    }

    public function redirect(string $uri, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: {$uri}");
        exit;
    }

    protected function extractParams(string $route, array $matches): array
    {
        preg_match_all('/:(\w+)/', $route, $paramNames);

        return array_combine($paramNames[1], $matches);
    }

    protected function callRoute(array $routeInfo, array $arguments = []): void
    {
        if (! class_exists($routeInfo['controller'])) {
            $this->abort(500, "Controller {$routeInfo['controller']} not found");

            return;
        }

        if (! method_exists($routeInfo['controller'], $routeInfo['method'])) {
            $this->abort(500, "Method {$routeInfo['method']} not found in controller {$routeInfo['controller']}");

            return;
        }

        if (isset($routeInfo['middleware'])) {
            $this->handleMiddleware($routeInfo['middleware']);
        }

        $controller = new $routeInfo['controller'];
        $controller->{$routeInfo['method']}(...$arguments);
    }

    protected function handleMiddleware(array $middlewares): void
    {
        foreach ($middlewares as $middlewareClass) {
            if (! class_exists($middlewareClass)) {
                throw new Exception("Middleware class {$middlewareClass} not found");
            }

            $middleware = new $middlewareClass;
            if (! $middleware instanceof MiddlewareInterface) {
                throw new Exception("Middleware {$middlewareClass} must implement MiddlewareInterface");
            }

            $middleware->handle($_REQUEST, fn () => null);
        }
    }

    protected function abort(int $statusCode, string $message): void
    {

        if ($statusCode === 404) {
            View::render([
                'view' => 'Error/404',
                'title' => 'Error 404',
            ]);
        }
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
        exit;
    }
}
