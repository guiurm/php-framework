<?php

namespace App\Controllers;

use Framework\Attributes\Route;
use Framework\Response;
use Framework\Routing\IRouteController;

class IndexController extends IRouteController
{

    #[Route('/')]
    public function index(): Response
    {
        return $this->response->setContent('Hellow, World!')
            ->setStatusCode(200);
    }
}
