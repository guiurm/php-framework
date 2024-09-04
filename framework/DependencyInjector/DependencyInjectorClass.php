<?php

namespace Framework\DependencyInjector;

use Framework\DependencyInjector\Models\DependencyInjectorAttribute;
use Framework\DependencyInjector\Models\DependencyInjectorMethod;
use Framework\DependencyInjector\Services\DependencyInjectorService;
use ReflectionClass;
use ReflectionMethod;

class DependencyInjectorClass
{
    private ReflectionClass $_reflection;
    /**
     * Summary of _methods
     * @var DependencyInjectorMethod[]
     */
    private $_methods = [];
    /**
     * Summary of _attributes
     * @var array<string, DependencyInjectorAttribute>
     */
    private $_attributes = [];

    public function __construct(
        string $class,
    ) {
        $this->_reflection = new ReflectionClass($class);
        //$this->_attributes = DependencyInjectorService::getClassAttributes($this->_reflection);
        $this->setClassAttributes();
        $this->setMethods();
    }

    private function setClassAttributes(): void
    {
        $this->_attributes = DependencyInjectorService::getClassAttributes($this->_reflection);
    }

    private function setMethods(): void
    {
        $reflectionMethods = $this->_reflection->getMethods();
        foreach ($reflectionMethods as $reflectionMethod) {
            $this->_methods[] = DependencyInjectorService::getMethod($reflectionMethod);
        }
    }

    /**
     * Summary of getAttributes
     * @return array<string,DependencyInjectorAttribute>
     */
    public function getClassAttributes()
    {
        return $this->_attributes;
    }

    public function getMethods()
    {
        return $this->_methods;
    }

    public function getInstance(...$args)
    {
        return $this->_reflection->newInstance(...$args);
    }
}
