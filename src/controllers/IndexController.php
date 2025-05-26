<?php

namespace App\Controllers;

use Framework\Attributes\Route;
use Framework\Events\EventDispatcher;
use Framework\Response;
use Framework\Routing\RouteBaseController;

class IndexController extends RouteBaseController
{

    #[Route('/')]
    public function index(EventDispatcher $eventDispatcher): Response
    {

        /* $eventDispatcher->addListener('kernel.request', function ($event) {
            $this->response->setContent('Hellow, World!')
                ->setStatusCode(200);
        });
        return $this->response;*/

        return $this->response->setContent('Hellow, World!')
            ->setStatusCode(200);
    }
}
