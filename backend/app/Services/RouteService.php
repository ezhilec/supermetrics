<?php

namespace App\Services;

class RouteService
{
    private string $path = '';
    private array $params = [];
    private array $routes = [];

    public function parseUrl(string $url): RouteService
    {
        $urlArray = parse_url($url);
        $path = $urlArray['path'];
        $params = [];

        if (isset($urlArray['query'])) {
            parse_str($urlArray['query'], $params);
        }

        $this->path = $path;
        $this->params = $params;

        return $this;
    }

    public function setRoutes(array $routes): RouteService
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function executeController()
    {
        [$controllerName, $method, $pathParams] = $this->findController();
        $fullControllerName = 'App\\Controllers\\' . $controllerName;

        if (!class_exists($fullControllerName)) {
            throw new \Exception('Controller not found');
        }

        $controller = new $fullControllerName();
        call_user_func_array([$controller, $method], [array_merge($this->params, $pathParams)]);
    }

    private function findController(): array
    {
        foreach ($this->routes as $route => $routeOptions) {
            $pathParams = [];
            if (preg_match($route, $this->path, $pathParams)) {

                $pathParams = array_filter($pathParams, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);
                return [
                    $routeOptions['name'],
                    $routeOptions['method'],
                    $pathParams
                ];
            }
        }

        return ['ErrorController', 'show404', []];
    }
}