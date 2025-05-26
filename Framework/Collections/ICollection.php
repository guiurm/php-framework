<?php

namespace Framework\Collections;

use Countable;
use IteratorAggregate;
use ArrayAccess;
use Traversable;

interface ICollection extends Countable, IteratorAggregate, ArrayAccess
{
    // protected  array $data;

    public function add(mixed $item, mixed $key = null): static;


    public function addMany(iterable $items): static;

    public function remove(mixed $key): bool;

    public function removeItem(mixed $item): bool;

    public function get(mixed $key): mixed;

    public function first(): mixed;

    public function last(): mixed;

    public function all(): array;

    public function isEmpty(): bool;

    public function count(): int;

    public function contains(mixed $item): bool;

    public function keyOf(mixed $item): mixed;

    public function clear(): void;

    public function forEach(callable $callback): void;

    public function filter(callable $callback): static;

    public function map(callable $callback): static;

    public function toArray(): array;

    public function getIterator(): Traversable;

    public function offsetExists(mixed $offset): bool;

    public function offsetGet(mixed $offset): mixed;

    public function offsetSet(mixed $offset, mixed $value): void;

    public function offsetUnset(mixed $offset): void;
}
