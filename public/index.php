<?php

declare(strict_types=1);

use App\Controllers\UserController;
use Framework\Request;
use Framework\Container;
use Framework\HttpKernel;
use Framework\Routing\Router;
use Framework\Routing\RouteLoader;
use Framework\Middleware\AuthMiddleware;

require_once __DIR__ . '/../framework/autoload.php';

$request = new Request(
    $_SERVER['REQUEST_METHOD'],
    strtok($_SERVER['REQUEST_URI'], '?'),
    $_GET,
    $_POST,
    getallheaders()
);

$router = new Router();
if (!$router->loadCachedRoutes()) {
    $loader = new RouteLoader();
    $routes = $loader->loadFromControllerDirectory(__DIR__ . '/../src/Controllers');

    /*
    $routes = $loader->loadFromControllerAttributes([
        UserController::class
    ]);
    */
    $router->setRoutes($routes);
    $router->cacheRoutes();
}

$container = new Container();
$kernel = new HttpKernel($router, $container);

// Añadir middlewares
$kernel->addMiddleware(new AuthMiddleware());

// Ejecutar
$response = $kernel->handle($request);
$response->send();
