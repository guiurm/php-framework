<?php

namespace Framework\DependencyInjector\Models;

class DependencyInjectorAttribute
{
    private string $name = '';

    private \ReflectionAttribute $reflection;

    /**
     * @var array<string, string>
     */
    private array $arguments = [];
    public function __construct() {}

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): DependencyInjectorAttribute
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Summary of setArguments
     * @param array<string, string> $arguments
     * @return DependencyInjectorAttribute
     */
    public function setArguments(array $arguments): DependencyInjectorAttribute
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function setReflection(\ReflectionAttribute $reflection): DependencyInjectorAttribute
    {
        $this->reflection = $reflection;
        return $this;
    }

    public function getReflection(): \ReflectionAttribute
    {
        return $this->reflection;
    }
}
