<?php

namespace Framework\Routing;

use Framework\Request;
use Framework\Response;

class RouteBaseController
{
    protected Response $response;
    protected Request $request;

    function __construct()
    {

        $this->response = new Response('', 200);
    }
    public function jsonResponse(mixed $data, int $statusCode = 200): Response
    {
        return  $this->response->setStatusCode($statusCode)->setHeader('Content-Type', 'application/json')->setContent(json_encode($data));
    }

    public function viewResponse(string $view, array $data = []): Response
    {
        // Suponiendo que tienes un motor de plantillas
        ob_start();
        extract($data);
        include __DIR__ . "/../../views/$view.php";
        $content = ob_get_clean();

        $this->response->setHeader('Content-Type', 'text/html');
        $this->response->setStatusCode(200);
        $this->response->setContent($content);
        // Aquí puedes usar un motor de plantillas como Twig o Blade
        return $this->response;
    }

    public function redirect(string $url): Response
    {
        $this->response->setStatusCode(302);
        $this->response->setHeader('Location', $url);
        $this->response->setContent('');

        return $this->response;
    }

    private function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }
}
