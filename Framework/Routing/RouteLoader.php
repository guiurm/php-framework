<?php

namespace Framework\Routing;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

use Framework\Routing\Route  as RouteModel;
use Framework\Attributes\Route as RouteAttribute;

class RouteLoader
{
    public function loadFromControllerDirectory(string $directory): RouteCollection
    {
        $collection = new RouteCollection();

        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($rii as $file) {

            if ($file->isDir() || $file->getExtension() !== 'php') {
                continue;
            }

            // Get the fully qualified class name from the file
            $className = $this->getClassFullNameFromFile($file->getPathname());
            if (!$className || !class_exists($className)) {
                continue;
            }


            $isRouteController = is_subclass_of($className, RouteBaseController::class) ? true : false;
            if (!$isRouteController) {
                continue;
            }

            $refClass = new ReflectionClass($className);

            $this->addClassReflectionToCollection($refClass, $collection, $className);
        }

        return $collection;
    }

    public function loadFromControllerArray(array $controllers): RouteCollection
    {
        $collection = new RouteCollection();

        foreach ($controllers as $className) {
            if (!class_exists($className)) {
                continue;
            }

            $refClass = new ReflectionClass($className);

            $this->addClassReflectionToCollection($refClass, $collection, $className);
        }

        return $collection;
    }

    private function addClassReflectionToCollection(ReflectionClass $refClass, RouteCollection $collection, string $className): void

    {

        $baseClassAtributePath = '';
        // Leer el atributo RouteAttribute a nivel de clase (si existe)
        $classAttributes = $refClass->getAttributes(RouteAttribute::class);
        if (!empty($classAttributes)) {
            $baseClassAtributePath = $classAttributes[0]->newInstance()->path ?? '';
        }

        foreach ($refClass->getMethods() as $method) {
            $attributes = $method->getAttributes(RouteAttribute::class);
            foreach ($attributes as $attribute) {
                $data = $attribute->newInstance();
                $collection->add(new RouteModel(
                    path: $baseClassAtributePath . $data->path,
                    method: $data->method,
                    controllerClass: $className,
                    controllerMethod: $method->getName(),
                    name: $data->name
                ));
            }
        }
    }

    /**
     * Extracts the fully qualified class name from a PHP file.
     */
    private function getClassFullNameFromFile(string $file): ?string
    {
        $src = file_get_contents($file);
        if (!preg_match('/namespace\s+(.+?);/', $src, $m)) {
            return null;
        }
        $namespace = $m[1];
        if (!preg_match('/class\s+([a-zA-Z0-9_]+)/', $src, $m)) {
            return null;
        }
        $class = $m[1];
        return $namespace . '\\' . $class;
    }
}
