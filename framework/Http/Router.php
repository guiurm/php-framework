<?php

namespace Framework\Http;

use framework\Attributes\Route;
use Framework\DependencyInjector\DependencyInjectorClass;
use Framework\DependencyInjector\Models\DependencyInjectorMethod;
use Framework\DependencyInjector\Services\DependencyInjectorService;

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
        $id = new DependencyInjectorClass($namespace);


        if (!$id->getReflection()->isSubclassOf(RequestController::class)) return $found;


        $classRoute = isset($id->getClassAttributes()[Route::class]) ? $id->getClassAttributes()[Route::class] : null;
        $baseUrl = "";

        if (null !== $classRoute) $baseUrl = $classRoute->getArguments()['path'];

        foreach ($id->getMethods() as $method) {
            if ($found) break;

            if (self::manageControllerMethod($method, $baseUrl, $request->getUri())) {
                $found = true;
                $args = DependencyInjectorService::gerArgs($method->getArguments());

                $method->reflection()->invoke($id->getInstance(), ...$args);
            }
        }

        return $found;
    }

    private static function manageControllerMethod(DependencyInjectorMethod $method, string $baseUrl, string $uri)
    {

        $currentMethodRouteAttribute = isset($method->getAttributes()[Route::class]) ? $method->getAttributes()[Route::class] : null;
        if (null === $currentMethodRouteAttribute) return false;
        $currentPath = rtrim($currentMethodRouteAttribute->getArguments()['path'], '/');
        if ($uri === $baseUrl . $currentPath || $uri === $baseUrl . $currentPath . '/') {
            return true;
        }

        return false;
    }
}
