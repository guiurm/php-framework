<?php

namespace Framework\Events;


class Event implements EventInterface
{
    protected bool $isCancelled = false;
    protected bool $propagate = true;
    protected array $data;

    public function __construct(
        protected string $name,
        array $data = []
    ) {
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isCancelled(): bool
    {
        return $this->isCancelled;
    }

    public function cancel(): self
    {
        $this->isCancelled = true;
        return $this;
    }

    public function shouldPropagate(): bool
    {
        return $this->propagate;
    }

    public function stopPropagation(): self
    {
        $this->propagate = false;
        return $this;
    }
}
