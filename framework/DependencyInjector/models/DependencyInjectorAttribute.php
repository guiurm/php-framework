<?php

namespace Framework\DependencyInjector\Models;

class DependencyInjectorAttribute
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var array<string, string>
     */
    private $arguments = [];
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
}
