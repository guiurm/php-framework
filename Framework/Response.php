<?php

namespace Framework;

class Response
{
    public function __construct(
        public string $content,
        public int $statusCode = 200
    ) {}

    public function send(): void
    {
        http_response_code($this->statusCode);
        echo $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
