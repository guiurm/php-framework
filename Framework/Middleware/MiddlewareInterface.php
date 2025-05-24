<?php

namespace Framework\Middleware;

use Framework\Request;
use Framework\Response;

interface MiddlewareInterface
{
    public function process(Request $request, callable $next): Response;
}
