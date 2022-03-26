<?php

use App\Services\ConfigService;
use App\Services\RouteService;

require(__DIR__ . '/vendor/autoload.php');

$url = $_SERVER['REQUEST_URI'];

//$a = preg_match('/^\/users\/(?<sad>.+)$/', '/users/1', $b);
//
//var_dump($b);
//exit;

try {
    $configService = new ConfigService();
    $routes = $configService->get('routes');

    $routeService = new RouteService();

    $routeService
        ->parseUrl($url)
        ->setRoutes($routes)
        ->executeController();
}  catch (\Throwable $e) {
    echo $e->getMessage();
}

