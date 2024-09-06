<?php

namespace Framework\DependencyInjector\Services;

use Exception;
use Framework\DependencyInjector\DependencyInjectorClass;
use Framework\DependencyInjector\Models\DependencyInjectorAttribute;
use Framework\DependencyInjector\Models\DependencyInjectorMethod;
use Framework\DependencyInjector\Models\DependencyInjectorMethodParameter;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

use function Src\Kernel\dd;

class DependencyInjectorService
{

    /**
     * Summary of getClassAttributes
     * @param ReflectionClass $reflectionClass
     * @return array<string,DependencyInjectorAttribute>
     */
    public static function getClassAttributes(ReflectionClass $reflectionClass)
    {
        /**
         * @var ReflectionAttribute[]
         */
        $classAttributes = $reflectionClass->getAttributes();

        /**
         * @var array<string,DependencyInjectorAttribute> $attributes
         */
        $attributes = [];

        foreach ($classAttributes as $attribute) {

            $att = new DependencyInjectorAttribute();
            $att->setName($attribute->getName())->setArguments($attribute->getArguments())->setReflection($attribute);

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
            $att->setName($attribute->getName())->setArguments($attribute->getArguments())->setReflection($attribute);
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

            $multipleTypes = strpos((string)$parameter->getType(), "|") ? true : false;
            $arg->setHasMultipleTypes($multipleTypes);

            $arg->setName($parameter->getName())
                ->setIsObject($arg->getHasMultipleTypes() ? false : ($parameter->getType()->isBuiltin() ? false : true))
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

    /**
     * Summary of Framework\Http\gerArgs
     * @param DependencyInjectorMethodParameter[] $dependencyInjectorMethodParameter
     * @return (null|object|string|int|array|false)[]
     */
    public static function instanceNewMethodParameter(
        array $dependencyInjectorMethodParameter
    ) {

        $args = [];
        foreach ($dependencyInjectorMethodParameter as $currentMethodArg) {
            if ($currentMethodArg->isOptional()) continue;
            if ($currentMethodArg->allowsNull()) {
                $args[$currentMethodArg->getArgPosition()] = null;
                continue;
            }

            $args[$currentMethodArg->getArgPosition()] = self::instanceNewParameterValue($currentMethodArg);
        }
        return $args;
    }
    public static function instanceNewParameterValue(DependencyInjectorMethodParameter $methodArg)
    {
        if ($methodArg->getIsObject()) {
            $id = new DependencyInjectorClass($methodArg->getType());
            return $id->getInstance();
        } else {
            switch ($methodArg->getType()) {
                case 'string':
                    $value = "";
                    break;

                case 'int':
                    $value = -1;
                    break;


                case 'array':
                    $value = [];
                    break;

                case 'bool':
                    $value = false;
                    break;

                default:
                    $value = null;
                    break;
            }
            return $value;
        }
    }

    public static function getNamespaceFromFile($rutaArchivo)
    {
        if (!file_exists($rutaArchivo)) {
            throw new Exception("File does not exist: " . $rutaArchivo);
        }

        $content = file_get_contents($rutaArchivo);

        $pattern = '/namespace\s+([^;]+);.*?class\s+(\w+)/s';

        if (preg_match($pattern, $content, $matches)) {
            $namespace = trim($matches[1]);
            $className = trim($matches[2]);

            return $namespace . '\\' . $className;
        }

        throw new Exception("Namespace or class not mached in file: $rutaArchivo");
    }

    public static function getInstanceFromAttribute(DependencyInjectorAttribute $attribute)
    {
        $args = self::parseAttributeArguments($attribute);
        $reflection = new ReflectionClass($attribute->getName());
        return $reflection->newInstanceArgs($args);
    }

    /**
     * Return attribute arguments in an array with ordered by constructor or by associative array
     * @param \Framework\DependencyInjector\Models\DependencyInjectorAttribute $attribute
     * @param bool $associative
     * @return array<string, string|null>
     */
    public static function parseAttributeArguments(DependencyInjectorAttribute $attribute, bool $associative = false)
    {
        /**
         * @var array<string, string|null>
         */
        $args = [];

        $constructor = (new ReflectionClass($attribute->getName()))->getConstructor();
        if (null === $constructor) return $args;

        $parameters = $constructor->getParameters();
        $arguments = $attribute->getArguments();

        foreach ($parameters as $parameter) {
            $value = $arguments[$parameter->getName()] ?? $arguments[$parameter->getPosition()] ?? null;

            if ($associative)
                $args[$parameter->getName()] = $value;
            else
                $args[$parameter->getPosition()] = $value;
        }

        return $args;
    }
}
