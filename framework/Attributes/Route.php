<?php

namespace framework\Attributes;

use Attribute;

#[Attribute]
class Route
{

    public function __construct(
        public ?string $alias = "",
        public ?string $path = null,
        public string | array $method,
    ) {}

    public function checkRoute(string $route): void {}
}
