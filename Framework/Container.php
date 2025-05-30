<?php

namespace Framework;

use ReflectionClass;

class Container
{
    private array $instances; // = [];

    public function __construct()
    {

        $this->instances = [];
    }

    public function set(string $id, object $service): void
    {
        $this->instances[$id] = $service;
    }

    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $refClass = new ReflectionClass($id);
        if (!$refClass->isInstantiable()) {
            throw new \Exception("No se puede instanciar '$id'");
        }

        $constructor = $refClass->getConstructor();
        if (!$constructor) {
            return $this->instances[$id] = new $id();
        }

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType()?->getName();
            if (!$type) {
                throw new \Exception("No se puede resolver el parámetro '{$param->getName()}' sin tipo");
            }
            $args[] = $this->get($type);
        }

        return $this->instances[$id] = $refClass->newInstanceArgs($args);
    }
}
