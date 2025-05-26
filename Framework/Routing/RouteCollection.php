<?php

namespace Framework\Routing;

use Framework\Collections\AbsCollection;

class RouteCollection extends AbsCollection
{
    /**
     * Summary of routes
     * @var Route[]
     */
    protected array $data; // = [];

    public function __construct(array $routes = [])
    {
        $this->data = $routes;
    }

    public function getByName(string $name): ?Route
    {
        foreach ($this->data as $route) {
            if ($route->name === $name) {
                return $route;
            }
        }
        return null;
    }
}
