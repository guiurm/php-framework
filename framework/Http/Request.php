<?php

namespace Framework\Http;

class Request
{
    public function __construct(
        private readonly array $_getParams,
        private readonly array $_postParams,
        private readonly array $_cookies,
        private readonly array $_files,
        private readonly array $_server,
    ) {}

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getUri()
    {
        return $this->_server["REQUEST_URI"];
    }

    public function getPath(): string
    {
        return parse_url($this->_server["REQUEST_URI"])['path'];
    }

    public function getQueryParams()
    {
        $url = parse_url($this->_server["REQUEST_URI"]);
        parse_str($url['query'] ?? '', $parsedQuery);

        return $parsedQuery;
    }

    public function getMethod()
    {
        return $this->_server["REQUEST_METHOD"];
    }
}
