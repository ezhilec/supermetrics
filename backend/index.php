<?php

use App\Services\ConfigService;
use App\Services\RouteService;

require(__DIR__ . '/vendor/autoload.php');

session_start();

$url = $_SERVER['REQUEST_URI'];

try {
    $routes = ConfigService::getInstance()->get('routes');

    $routeService = new RouteService();

    $routeService
        ->parseUrl($url)
        ->setRoutes($routes)
        ->executeController();

}  catch (\Throwable $e) {
    echo $e->getMessage();
}

