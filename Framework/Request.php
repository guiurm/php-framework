<?php

namespace Framework;

class Request
{
    public function __construct(
        public string $method,
        public string $uri,
        public array $query = [],
        public array $body = [],
        public array $headers = [],
    ) {}

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }
}
