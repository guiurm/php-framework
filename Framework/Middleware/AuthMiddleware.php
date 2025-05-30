<?php

namespace Framework\Middleware;

use Framework\Request;
use Framework\Response;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Request
    {
        if ($request->getHeader('x-api-key') !== 'secret123') {
            // return new Response("Unauthorized", 401);
        }
        return $next($request);
    }
}
