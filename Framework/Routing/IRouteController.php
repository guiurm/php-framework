<?php

namespace Framework\Routing;

use Framework\Response;

class IRouteController
{
    protected Response $response;

    public function __construct()
    {
        $this->response = new Response('', 200);
    }
}
