<?php

namespace Framework\Http;

class Request
{
    public function __construct(
        private readonly array $_getParams,
        private readonly array $_postParams,
        private readonly array $_cookies,
        private readonly array $_files,
        // private readonly array $_headers,
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
}
