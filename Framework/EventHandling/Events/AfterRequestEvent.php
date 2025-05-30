<?php

namespace Framework\EventHandling\Events;

use Framework\Request;

class AfterRequestEvent
{
    public function __construct(
        private Request $request
    ) {}

    public function getRequest(): Request
    {
        return $this->request;
    }
}
