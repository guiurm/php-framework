<?php

namespace Framework\EventHandling\Events;

use Framework\Request;

class BeforeMiddlewareEvent
{
    public function __construct(
        private Request $request
    ) {}

    public function getRequest(): Request
    {
        return $this->request;
    }
}
