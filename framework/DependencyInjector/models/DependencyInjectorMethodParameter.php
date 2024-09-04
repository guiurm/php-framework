<?php

namespace Framework\DependencyInjector\Models;

use ReflectionParameter;

class DependencyInjectorMethodParameter
{
    private string $_name;
    private string $_type;
    private bool $_isObject;
    private ReflectionParameter $_reflectionParameter;

    public function __construct(ReflectionParameter $reflectionParameter)
    {
        $this->_reflectionParameter = $reflectionParameter;
    }

    public function getName(): string
    {
        return $this->_name;
    }
    public function getType(): string
    {
        return $this->_type;
    }
    public function getIsObject(): bool
    {
        return $this->_isObject;
    }

    public function setName(string $name): DependencyInjectorMethodParameter
    {
        $this->_name = $name;
        return $this;
    }
    public function setType(string $type): DependencyInjectorMethodParameter
    {
        $this->_type = $type;
        return $this;
    }
    public function setIsObject(bool $isObject): DependencyInjectorMethodParameter
    {
        $this->_isObject = $isObject;
        return $this;
    }
    public function allowsNull()
    {
        return $this->_reflectionParameter->allowsNull();
    }
    public function isOptional()
    {
        return $this->_reflectionParameter->isOptional();
    }

    public function getArgPosition()
    {
        return $this->_reflectionParameter->getPosition();
    }
}
