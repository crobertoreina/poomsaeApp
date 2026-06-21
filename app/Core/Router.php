<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $base = rtrim(BASE_PATH, '/');
        if (str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base)) ?: '/';
        }

        $methodRoutes = $this->routes[$method] ?? [];

        foreach ($methodRoutes as $pattern => $handler) {
            $regex = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $pattern);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->callHandler($handler, $params);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function callHandler(callable|array $handler, array $params): void
    {
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $controller = new $class();
            $controller->$method(...$params);
        } else {
            $handler($params);
        }
    }
}
