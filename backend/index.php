<?php

use App\Services\EnvService;
use App\Services\ConfigService;
use App\Services\RouteService;
use App\Controllers\ErrorController;

require(__DIR__ . '/vendor/autoload.php');

session_start();

$url = $_SERVER['REQUEST_URI'];

try {
    EnvService::init();

    $routes = ConfigService::instance()->get("routes");

    $routeService = new RouteService();

    $routeService
        ->parseUrl($url)
        ->setRoutes($routes)
        ->executeController();

}  catch (Throwable $e) {
    (new ErrorController())->exceptionError($e->getMessage());
}

