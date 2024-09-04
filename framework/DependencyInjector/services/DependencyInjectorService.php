<?php

namespace Framework\DependencyInjector\Services;

use Framework\DependencyInjector\Models\DependencyInjectorAttribute;
use Framework\DependencyInjector\Models\DependencyInjectorMethod;
use Framework\DependencyInjector\Models\DependencyInjectorMethodParameter;
use ReflectionClass;
use ReflectionMethod;

class DependencyInjectorService
{

    /**
     * Summary of getClassAttributes
     * @param \ReflectionClass $reflectionClass
     * @return array<string,DependencyInjectorAttribute>
     */
    public static function getClassAttributes(ReflectionClass $reflectionClass)
    {
        $classAttributes = $reflectionClass->getAttributes();

        /**
         * @var array<string,DependencyInjectorAttribute> $attributes
         */
        $attributes = [];

        foreach ($classAttributes as $attribute) {

            $att = new DependencyInjectorAttribute();
            $att->setName($attribute->getName())->setArguments($attribute->getArguments());

            $attributes[$att->getName()] = $att;
        }

        return $attributes;
    }

    public static function getMethodAttributes(ReflectionMethod $reflectionMethod)
    {
        $classAttributes = $reflectionMethod->getAttributes();
        $attributes = [];
        foreach ($classAttributes as $attribute) {
            $att = new DependencyInjectorAttribute();
            $att->setName($attribute->getName())->setArguments($attribute->getArguments());
            $attributes[$att->getName()] = $att;
        }
        return $attributes;
    }

    public static function getMethodArguments(ReflectionMethod $reflectionMethod)
    {
        $reflectionParameters = $reflectionMethod->getParameters();
        /**
         * @var DependencyInjectorMethodParameter[]
         */
        $arguments = [];
        foreach ($reflectionParameters as $parameter) {
            $arg = new DependencyInjectorMethodParameter($parameter);
            $arg->setName($parameter->getName())
                ->setIsObject($parameter->getType()->isBuiltin() ? false : true)
                ->setType($arg->getIsObject() ? $parameter->getType()->getName() : $parameter->getType());

            $parameter->allowsNull();
            $parameter->isOptional();
            $arguments[] = $arg;
        }

        return $arguments;
    }

    public static function getMethod(ReflectionMethod $reflectionMethod)
    {
        $method = new DependencyInjectorMethod($reflectionMethod);
        $method->setName($reflectionMethod->getName());

        $method->setArguments(DependencyInjectorService::getMethodArguments($reflectionMethod));
        $method->setAttributes(DependencyInjectorService::getMethodAttributes($reflectionMethod));

        return $method;
    }
}
