<?php

namespace Framework\Routing;

class RouteCollection
{
    private array $routes = [];

    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function all(): array
    {
        return $this->routes;
    }

    public function getByName(string $name): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->name === $name) {
                return $route;
            }
        }
        return null;
    }
}
