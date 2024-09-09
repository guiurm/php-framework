<?php

namespace Framework\Http;

class Response
{
    protected string $_content;

    public function __construct(?string $content = "")
    {
        $this->_content = $content;
    }

    public function setCoockie(
        string $name,
        string $value = "",
        int $expires_or_options = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false,
        bool $httponly = false
    ) {
        setcookie($name, $value, $expires_or_options, $path, $domain, $secure, $httponly);
        return $this;
    }
    public function setHeader(string $header, bool $replace = true)
    {
        header($header, $replace);
        return $this;
    }

    /**
     * Set response code to the client
     * @param int $code Value from file: \Framework\Http\HTTPResponseCode
     * @return static
     */
    public function setResponseCode(int $code)
    {
        http_response_code($code);
        return $this;
    }

    public function setContent(string $content)
    {
        $this->_content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->_content;
    }
}
