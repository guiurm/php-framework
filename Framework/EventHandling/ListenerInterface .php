<?php

namespace Framework\EventHandling;

interface ListenerInterface
{
    public function handle(object $event): void;
}
