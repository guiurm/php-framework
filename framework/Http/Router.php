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
        $id = new DependencyInjectorClass($namespace);


        if (!$id->getReflection()->isSubclassOf(RequestController::class)) return $found;


        $classRoute = isset($id->getClassAttributes()[Route::class]) ? $id->getClassAttributes()[Route::class] : null;
        $baseUrl = "";

        if (null !== $classRoute) {
            $route = self::parseRouteAttribute($classRoute);
            $baseUrl = $route->path;
        }

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


    private static function parseRouteAttribute(DependencyInjectorAttribute $attribute): Route
    {
        $id = new DependencyInjectorClass($attribute->getReflection()->getName());
        $r = new ReflectionClass($attribute->getName());

        return null === $r->getConstructor() ? $ins = self::noCons($id) : $ins = self::cons($r, $attribute);
    }

    private static function noCons(DependencyInjectorClass $id)
    {
        return $id->getReflection()->newInstance();
    }

    private static function cons(ReflectionClass $r, DependencyInjectorAttribute $attribute): object
    {
        $parameters = $r->getConstructor()->getParameters();
        $arguments = $attribute->getArguments();
        $args = [];
        foreach ($parameters as $parameter) {
            $value = $arguments[$parameter->getName()] ?? $arguments[$parameter->getPosition()] ?? null;
            $args[$parameter->getPosition()] = $value;
        }
        dd($args);
        return $r->newInstanceArgs($args);
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
