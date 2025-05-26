<?php

namespace Framework\Events;

class EventDispatcher
{
    protected array $listeners = [];

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function removeListener(string $eventName, callable $listener): void
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }
        $this->listeners[$eventName] = array_filter(
            $this->listeners[$eventName],
            fn($l) => $l !== $listener
        );
    }

    public function dispatch(EventInterface $event): EventInterface
    {
        $eventName = $event->getName();
        if (!isset($this->listeners[$eventName])) {
            return $event;
        }

        foreach ($this->listeners[$eventName] as $listener) {
            $listener($event);
            if ($event->isCancelled() || !$event->shouldPropagate()) {
                break;
            }
        }
        return $event;
    }
}
