<?php

namespace framework\Attributes;

use Attribute;

#[Attribute]
class Route
{
    public string $alias;
    public string $path;
    public array $methods;

    public function __construct(
        string $alias = "",
        string $path = "",
        string |array $method = "GET",
    ) {
        $this->alias = $alias;
        $this->path = $path;
        $this->methods = is_array($method) ? $method : [$method];
    }

    public function checkRoute(string $route): void {}
}
