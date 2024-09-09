<?php

namespace Framework\Http;

use Framework\Http\HTTPResponseCode;

abstract class RequestController
{

    public function __construct() {}

    /**
     * Summary of renderView
     * @param string $file
     * @param array<string, string> $variables
     * @return Response
     */
    protected function render(string $file, ?array $variables = []): Response
    {

        $content = $this->renderView($file, $variables);

        return (new Response($content))->setResponseCode(HTTPResponseCode::OK);
    }

    /**
     * Summary of renderView
     * @param string $file
     * @param array<string, string> $variables
     * @return string
     */
    protected function renderView(string $file, ?array $variables = []): string
    {
        /*eval('?>' . file_get_contents($file));

        return ob_get_clean();*/

        ob_start();

        foreach ($variables as $key => $value) {
            $$key = $value;
        }

        include $file;

        return ob_get_clean();
    }
}
