<?php

namespace Framework\Http;

abstract class RequestController
{

    public function __construct() {}

    /**
     * Summary of renderView
     * @param string $file
     * @param array<string, string> $variables
     * @return never
     */
    protected function renderView(string $file, ?array $variables = []): string
    {
        /*extract($variables);
        include $file;
        die();*/
        ob_start();

        foreach ($variables as $key => $value) {
            $$key = $value;
        }

        include $file;

        return ob_get_clean();
    }
}
