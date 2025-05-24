<?php

namespace Framework\Routing;

use Framework\Request;

class Router
{
    private RouteCollection $routes;
    // private string $cachePath = __DIR__ . '/../../../var/cache/routes.cache';
    private string $cachePath = '/app/var/cache/routes.cache';

    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function setRoutes(RouteCollection $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * Summary of match
     * @param \Framework\Request $request
     * @return array{params: array, route: \Framework\Routing\Route|null}
     */
    public function match(Request $request): ?array
    {
        foreach ($this->routes->all() as $route) {
            if (strtoupper($request->method) !== strtoupper($route->method)) {
                continue;
            }

            if (preg_match($route->regex, $request->uri, $matches)) {
                array_shift($matches);
                preg_match_all('/\\{(\\w+)/', $route->path, $paramNames);
                $params = array_combine($paramNames[1], $matches);
                return ['route' => $route, 'params' => $params];
            }
        }

        return null;
    }

    public function generateUrl(string $name, array $params = []): ?string
    {
        $route = $this->routes->getByName($name);
        if (!$route) return null;

        return preg_replace_callback('/\\{(\\w+)(<[^>]+>)?\\}/', function ($m) use ($params) {
            $param = $params[$m[1]] ?? null;
            if (!$param) {
                throw new \InvalidArgumentException("Falta el parámetro '{$m[1]}'");
            }
            return $param;
        }, $route->path);
    }

    public function loadCachedRoutes(): bool
    {
        if (file_exists($this->cachePath)) {
            $routesData = include $this->cachePath;
            // $this->routes = unserialize($routesData);
            // return true;
        }
        return false;
    }

    public function cacheRoutes(): void
    {
        file_put_contents($this->cachePath, '<?php return ' . var_export(serialize($this->routes), true) . ';');
    }
}
