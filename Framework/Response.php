<?php

namespace Framework;

class Response
{
    public function __construct(
        public string $content,
        public int $statusCode = 200,
        public array $headers = []
    ) {}

    // Establecer un header específico
    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    // Obtener un header
    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    // Enviar la respuesta al navegador
    public function send(): void
    {
        // Establecer el código de estado HTTP
        http_response_code($this->statusCode);

        // Establecer los headers
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Enviar el contenido de la respuesta
        echo $this->content;
        die();
    }

    // Crear una respuesta JSON
    public static function json(mixed $data, int $statusCode = 200): self
    {
        $jsonContent = json_encode($data);
        return new self($jsonContent, $statusCode, ['Content-Type' => 'application/json']);
    }

    // Redirigir a una URL
    public static function redirect(string $url, int $statusCode = 302): self
    {
        return new self('', $statusCode, ['Location' => $url]);
    }

    // Crear una respuesta HTML
    public static function html(string $content, int $statusCode = 200): self
    {
        return new self($content, $statusCode, ['Content-Type' => 'text/html']);
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
