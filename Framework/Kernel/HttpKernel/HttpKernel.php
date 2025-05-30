<?php

namespace Framework\Kernel\HttpKernel;

// use Framework\Events\EventDispatcher;

use Exception;
use Framework\Constants\FrameworkError;
use Framework\EventHandling\EventDispatcher;
use Framework\EventHandling\Events\AfterMiddlewareEvent;
use Framework\EventHandling\Events\AfterRequestEvent;
use Framework\EventHandling\Events\BeforeMiddlewareEvent;
use Framework\EventHandling\Events\BeforeRequestEvent;
use Framework\Kernel\Container\ContainerSingleton;
use Framework\Exceptions\NotFoundException;
use Framework\Request;
use Framework\Response;
use Framework\Routing\Router;
use Framework\Middleware\MiddlewareInterface;
use ReflectionMethod;

class HttpKernel
{
    /**
     * Summary of middlewares
     * @var MiddlewareInterface[]
     */
    private array $middlewares = [];
    private EventDispatcher $dispatcher;

    public function __construct(
        private Router $router,
        // private Container $container,
        // public EventDispatcher $eventDispatcher = new EventDispatcher()
    ) {
        $this->dispatcher = ContainerSingleton::getInstance()->get(EventDispatcher::class);
    }

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request): Response
    {
        $this->dispatcher->dispatch(new BeforeRequestEvent($request));
        // $this->container->set(EventDispatcher::class, $this->eventDispatcher);


        try {

            $request = $this->applyMiddlewares($request);
        } catch (Exception $e) {
            return new Response(
                "Error applying middleware: '" . $e->getMessage() . "' (" . FrameworkError::APPLY_MIDDLEWARE_ERROR . ")"
            )->setStatusCode(500);
        }

        $match = $this->router->match($request);
        if (!$match) {
            return new Response(
                "Not Found"
            )->setStatusCode(500);
            // throw new NotFoundException("Route not found for {$request->getMethod()} {$request->getUri()}", 404);
        }

        $route = $match['route'];
        $params = $match['params'] ?? [];

        // $controller = $this->container->get($route->controllerClass);
        $controller = ContainerSingleton::getInstance()->get($route->controllerClass);

        if (is_subclass_of($controller, \Framework\Routing\RouteBaseController::class)) {
            $reflection = new ReflectionMethod($controller, 'setRequest');
            $reflection->setAccessible(true);

            $reflection->invoke($controller, request: $request);
        }

        $method = $route->controllerMethod ?? '__invoke';

        $refMethod = new ReflectionMethod($controller, $method);
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
                $args[] = ContainerSingleton::getInstance()->get($type);
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } else {
                return new Response("Falta el parámetro '$name'", 400);
            }
        }

        /**
         * @var Response $response
         */
        $response = $refMethod->invokeArgs($controller, $args);

        $this->dispatcher->dispatch(new AfterRequestEvent($request));

        return $response;
    }

    private function applyMiddlewares(Request $request): Request
    {

        $this->dispatcher->dispatch(new BeforeMiddlewareEvent($request));

        $chain = array_reduce(
            array_reverse($this->middlewares),
            fn($next, $middleware) => fn($req) => $middleware->process($req, $next),
            fn($req) => $req
        );

        $this->dispatcher->dispatch(new AfterMiddlewareEvent($request));

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
