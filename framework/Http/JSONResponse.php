<?php

namespace Framework\Http;

use Framework\Serializer\JSONConverter;

class JSONResponse extends Response
{
    public function __construct(?object $content)
    {
        if (null !== $content) {
            parent::setContent((new JSONConverter())->serialize($content));
        }

        parent::setHeader('Content-Type: application/json; charset=utf-8');
    }
}
