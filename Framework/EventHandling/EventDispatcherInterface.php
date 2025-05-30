<?php

namespace Framework\EventHandling;

interface EventDispatcherInterface
{
    public function addListener(string $eventName, callable $listener): void;
    public function dispatch(object $event): object;
}
