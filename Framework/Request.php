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

    public static function createFromGlobals(): self
    {
        return new self(
            method: $_SERVER['REQUEST_METHOD'],
            uri: strtok($_SERVER['REQUEST_URI'], '?'),
            query: $_GET,
            body: $_POST,
            headers: getallheaders()
        );
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getParameter(string $name): mixed
    {
        return $this->query[$name] ?? $this->body[$name] ?? null;
    }
}
