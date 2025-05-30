<?php

namespace Framework\Middleware;

use Framework\Request;

interface MiddlewareInterface
{
    public function process(Request $request, callable $next): Request;
}
