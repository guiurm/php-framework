<?php

namespace Framework\Http;

use framework\Attributes\Route;
use Framework\DependencyInjector\DependencyInjectorClass;
use Framework\DependencyInjector\Models\DependencyInjectorAttribute;
use Framework\DependencyInjector\Models\DependencyInjectorMethod;
use Framework\DependencyInjector\Services\DependencyInjectorService;

use function Src\Kernel\dd;

class Router
{
    public static function manageRequest(Request $request)
    {
        $response = (new Response())
            ->setResponseCode(HTTPResponseCode::NOT_FOUND)
            ->setContent(HTTPResponseCode::MESSAGE_HTTP[HTTPResponseCode::NOT_FOUND]);

        foreach (self::getControllerFiles() as $currentNamespace) {
            if ($currentResponse = self::manageController($currentNamespace, $request)) {
                $response = $currentResponse;
            }
        }

        echo $response->getContent();
        die();
    }

    private static function getControllerFiles()
    {
        /**
         * @var string[]
         */
        $namespaces = [];
        foreach (glob(__ROOT__ . "src/Controllers/*.php") as $filename) {
            $namespaces[] = DependencyInjectorService::getNamespaceFromFile($filename);
        }
        return $namespaces;
    }

    private static function manageController(string $namespace, Request $request)
    {
        $dependencyInjectionClass = new DependencyInjectorClass($namespace);

        if (!$dependencyInjectionClass->getReflection()->isSubclassOf(RequestController::class)) return;

        $baseUrl = "";

        if (array_key_exists(Route::class, $dependencyInjectionClass->getClassAttributes())) {
            $route = self::parseRouteAttribute($dependencyInjectionClass->getClassAttributes()[Route::class]);
            $baseUrl = $route->path;
        }

        foreach ($dependencyInjectionClass->getMethods() as $method) {
            if (self::validControllerMethod($method, $baseUrl, $request)) {
                return self::manageControllerMethod($dependencyInjectionClass, $method);
            }
        }
    }

    private static function manageControllerMethod(DependencyInjectorClass $dependencyInjectionClass, DependencyInjectorMethod $method)
    {
        $args = DependencyInjectorService::instanceNewMethodParameter($method->getArguments());
        /**
         * @var Response
         */
        $response = $method->reflection()->invoke($dependencyInjectionClass->getInstance(), ...$args);
        if (!($response instanceof Response)) throw new \ErrorException("The return type is not expected");

        return $response;
    }


    private static function parseRouteAttribute(DependencyInjectorAttribute $attribute): Route
    {
        return DependencyInjectorService::getInstanceFromAttribute($attribute);
    }

    private static function validControllerMethod(DependencyInjectorMethod $method, string $baseUrl, Request $request)
    {
        if (!array_key_exists(Route::class, $method->getAttributes()))
            return false;

        $route = self::parseRouteAttribute($method->getAttributes()[Route::class]);
        $route->path = "$baseUrl$route->path";
        return $request->validateRequest($route);
    }
}
