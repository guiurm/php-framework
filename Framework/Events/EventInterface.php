<?php

namespace Framework\Events;

interface EventInterface
{
    public function getName(): string;
    public function getData(): array;
    public function isCancelled(): bool;
    public function cancel(): self;
    public function shouldPropagate(): bool;
    public function stopPropagation(): self;
}
