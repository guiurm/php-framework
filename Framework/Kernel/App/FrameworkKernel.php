<?php

namespace Framework\Kernel\App;

use Framework\EventHandling\EventDispatcher;
use Framework\Kernel\Container\ContainerSingleton;
use Framework\Discover\FrameworkDiscover;
use Framework\Kernel\HttpKernel\HttpKernel;
use Framework\Middleware\AuthMiddleware;
use Framework\Request;
use Framework\Routing\RouteBaseController;
use Framework\Routing\RouteLoader;
use Framework\Routing\Router;
use ReflectionClass;

class FrameworkKernel
{
    private static FrameworkKernel $instance;
    private Router $router;
    // private Container $container;
    private HttpKernel $httpKernel;
    // private EventDispatcher $eventDispatcher;
    private EventDispatcher $eventDistpacher;

    public static string $APP_PATH = __DIR__ . '/../../../src';

    public function __construct()
    {
        if (isset(self::$instance)) {
            self::$instance;
        } else {

            $this->router = new Router();
            // $this->container = new Container();
            $this->eventDistpacher = new EventDispatcher();
            $this->httpKernel = new HttpKernel(
                router: $this->router,
                // container: $this->container,
                // eventDispatcher: $this->eventDispatcher
            );

            ContainerSingleton::getInstance()->set(EventDispatcher::class, $this->eventDistpacher);

            self::$instance = $this;
        }
    }

    public static function getInstance(): FrameWorkKernel
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getHttpKernel(): HttpKernel
    {
        return $this->httpKernel;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function getContainer(): ContainerSingleton
    {
        return ContainerSingleton::getInstance();
    }


    private function loadAutoDiscover()
    {
        $routeControllers = [];
        $eventDistpachers = [];
        $eventModels = [];

        $frameWorkDiscover = new FrameworkDiscover(FrameworkKernel::$APP_PATH, [
            RouteBaseController::class => function (ReflectionClass $refClass) use (&$routeControllers) {
                $routeControllers[] = $refClass->getName();
            },
            // Event::class => function (ReflectionClass $refClass) use (&$eventModels) {
            //     $eventModels[] = $refClass->getName();
            // },
            // EventDispatcher::class => function (ReflectionClass $refClass) use (&$eventDistpachers) {
            //     $eventDistpachers[] = $refClass->getName();
            // },
        ]);

        $frameWorkDiscover->discover();

        $this->loadRoutesFromControllers($routeControllers);
    }

    private function loadRoutesFromControllers(array $routeControllers): void
    {
        $routes = new RouteLoader()->loadFromControllerArray($routeControllers);
        $this->router->setRoutes($routes);
    }

    public function handle(?Request $request = null): void
    {

        $this->loadAutoDiscover();

        $request = Request::createFromGlobals();


        $router = $this->router;
        if (!$router) {
            throw new \RuntimeException('Router is not initialized.');
        }

        /*
        if (!$router->loadCachedRoutes()) {
            $loader = new RouteLoader();
            $routes = $loader->loadFromControllerDirectory(__DIR__ . '/../../src/Controllers');

            // $routes = $loader->loadFromControllerAttributes([UserController::class]);
            $router->setRoutes($routes);
            //$router->cacheRoutes();
        }
        */

        $this->httpKernel->addMiddleware(new AuthMiddleware());



        $response = $this->httpKernel->handle($request);
        $response->send();
    }
}
