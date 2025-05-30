<?php

namespace Framework\EventHandling;

class BaseSubscriber implements ListenerInterface
{
    public function handle(object $event): void {}
}
