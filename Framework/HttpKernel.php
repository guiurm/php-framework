<?php

namespace Framework;

use Framework\Request;
use Framework\Response;
use Framework\Routing\Router;
use Framework\Middleware\MiddlewareInterface;

class HttpKernel
{
    private array $middlewares = [];

    public function __construct(
        private Router $router,
        private Container $container
    ) {}

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request): Response
    {
        return $this->applyMiddlewares($request, function (Request $request) {
            $match = $this->router->match($request);
            if (!$match) return new Response("404 Not Found", 404);

            $route = $match['route'];
            $params = $match['params'] ?? [];
            $controller = $this->container->get($route->controllerClass);
            $method = $route->controllerMethod ?? '__invoke';

            $refMethod = new \ReflectionMethod($controller, $method);
            $args = [];

            foreach ($refMethod->getParameters() as $param) {
                $name = $param->getName();
                $type = $param->getType()?->getName();

                if ($type === Request::class) {
                    $args[] = $request;
                } elseif (array_key_exists($name, $params)) {
                    if (!$this->validateParameter($params[$name], $type)) {
                        return new Response("Parámetro '$name' inválido", 400);
                    }
                    $args[] = $this->cast($params[$name], $type);
                } elseif (class_exists($type)) {
                    $args[] = $this->container->get($type);
                } elseif ($param->isDefaultValueAvailable()) {
                    $args[] = $param->getDefaultValue();
                } else {
                    return new Response("Falta el parámetro '$name'", 400);
                }
            }

            return $refMethod->invokeArgs($controller, $args);
        });
    }

    private function applyMiddlewares(Request $request, callable $handler): Response
    {
        $chain = array_reduce(
            array_reverse($this->middlewares),
            fn($next, $middleware) => fn($req) => $middleware->process($req, $next),
            $handler
        );
        return $chain($request);
    }

    private function validateParameter(mixed $value, ?string $type): bool
    {
        return match ($type) {
            'int'   => filter_var($value, FILTER_VALIDATE_INT) !== false,
            'float' => filter_var($value, FILTER_VALIDATE_FLOAT) !== false,
            'bool'  => in_array(strtolower($value), ['true', 'false', '1', '0'], true),
            'string' => is_string($value),
            default => true,
        };
    }

    private function cast(mixed $value, ?string $type): mixed
    {
        return match ($type) {
            'int'   => (int) $value,
            'float' => (float) $value,
            'bool'  => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            default => $value,
        };
    }
}
