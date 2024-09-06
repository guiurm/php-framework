<?php

namespace Framework\Http;

use framework\Attributes\Route;
use Framework\DependencyInjector\DependencyInjectorClass;
use Framework\DependencyInjector\Models\DependencyInjectorAttribute;
use Framework\DependencyInjector\Models\DependencyInjectorMethod;
use Framework\DependencyInjector\Services\DependencyInjectorService;
use ReflectionClass;

use function Src\Kernel\dd;

class Router
{
    public static function manageRequest(Request $request)
    {
        $found = false;
        foreach (self::getControllerFiles() as $currentNamespace) {
            $found = self::manageController($currentNamespace, $request);
            if ($found) break;
        }

        if (!$found) {
            //throw new \Exception("Uri not found");
            dd($request->getUri() . ' not found');
        }
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

        $found = false;
        $dependencyInjectionClass = new DependencyInjectorClass($namespace);

        if (!$dependencyInjectionClass->getReflection()->isSubclassOf(RequestController::class)) return $found;

        $baseUrl = "";

        if (array_key_exists(Route::class, $dependencyInjectionClass->getClassAttributes())) {
            $route = self::parseRouteAttribute($dependencyInjectionClass->getClassAttributes()[Route::class]);
            $baseUrl = $route->path;
        }

        foreach ($dependencyInjectionClass->getMethods() as $method) {
            if ($found) break;

            if ($found = self::validControllerMethod($method, $baseUrl, $request)) {

                $args = DependencyInjectorService::instanceNewMethodParameter($method->getArguments());

                $method->reflection()->invoke($dependencyInjectionClass->getInstance(), ...$args);
            }
        }

        return $found;
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

        return $request->validateRequest($route, $baseUrl);
    }
}
