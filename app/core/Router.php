<?php

class Router
{
    private $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method)
    {
        if (isset($this->routes[$method][$uri])) {
            $this->runAction($this->routes[$method][$uri]);
            return;
        }

        foreach ($this->routes[$method] as $route => $action) {
            if (strpos($route, '{') !== false) {

                $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
                $pattern = "#^" . $pattern . "$#";

                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches);
                    $this->runAction($action, $matches);
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function runAction($action, $params = [])
    {
        list($controller, $method) = explode('@', $action);

        require_once __DIR__ . "/../controllers/$controller.php";

        $controller = new $controller;

        call_user_func_array([$controller, $method], $params);
    }
}