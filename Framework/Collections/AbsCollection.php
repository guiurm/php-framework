<?php

namespace Framework\Collections;

use Countable;
use IteratorAggregate;
use ArrayAccess;
use Traversable;

abstract class AbsCollection implements ICollection //Countable, IteratorAggregate, ArrayAccess
{
    protected  array $data;

    public function add(mixed $item, mixed $key = null): static
    {
        if ($key === null) {
            $this->data[] = $item;
        } else {
            $this->data[$key] = $item;
        }
        return $this;
    }

    public function addMany(iterable $items): static
    {
        foreach ($items as $key => $item) {
            $this->add($item, $key);
        }
        return $this;
    }

    public function remove(mixed $key): bool
    {
        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

    public function removeItem(mixed $item): bool
    {
        $key = $this->keyOf($item);
        if ($key !== null) {
            return $this->remove($key);
        }
        return false;
    }

    public function get(mixed $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function first(): mixed
    {
        return !empty($this->data) ? reset($this->data) : null;
    }

    public function last(): mixed
    {
        return !empty($this->data) ? end($this->data) : null;
    }

    public function all(): array
    {
        return $this->data;
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function contains(mixed $item): bool
    {
        return in_array($item, $this->data, true);
    }

    public function keyOf(mixed $item): mixed
    {
        $key = array_search($item, $this->data, true);
        return $key !== false ? $key : null;
    }

    public function clear(): void
    {
        $this->data = [];
    }

    public function forEach(callable $callback): void
    {
        foreach ($this->data as $key => $item) {
            $callback($item, $key);
        }
    }

    public function filter(callable $callback): static
    {
        $filtered = array_filter($this->data, $callback, ARRAY_FILTER_USE_BOTH);
        $collection = clone $this;
        $collection->data = $filtered;
        return $collection;
    }

    public function map(callable $callback): static
    {
        $mapped = [];
        foreach ($this->data as $key => $item) {
            $mapped[$key] = $callback($item, $key);
        }
        $collection = clone $this;
        $collection->data = $mapped;
        return $collection;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    // IteratorAggregate
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->data);
    }

    // ArrayAccess
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->add($value, $offset);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }
}
