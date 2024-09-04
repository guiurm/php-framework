<?php

namespace Framework\DependencyInjector\Models;

use ReflectionMethod;

class DependencyInjectorMethod
{

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var DependencyInjectorMethodParameter[]
     */
    private $arguments = [];
    /**
     * @var DependencyInjectorAttribute[]
     */
    private $attributes = [];
    private ReflectionMethod $_reflectionMethod;
    public function __construct(ReflectionMethod $reflectionMethod)
    {
        $this->_reflectionMethod = $reflectionMethod;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): DependencyInjectorMethod
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Summary of setArguments
     * @param DependencyInjectorMethodParameter[]
     * @return DependencyInjectorMethod
     */
    public function setArguments(array $arguments): DependencyInjectorMethod
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * Summary of getArguments
     * @return DependencyInjectorMethodParameter[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }



    /**
     * Summary of setArguments
     * @param DependencyInjectorAttribute[]
     * @return DependencyInjectorMethod
     */
    public function setAttributes(array $attributes): DependencyInjectorMethod
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Summary of getArguments
     * @return DependencyInjectorAttribute[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function reflection()
    {
        return $this->_reflectionMethod;
    }
}
