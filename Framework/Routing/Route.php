<?php

namespace Framework\Routing;

class Route
{
    public string $regex;

    public function __construct(
        public string $path,
        /**
         * @var string|string[]
         */
        public string|array $method,
        public string $controllerClass,
        public ?string $controllerMethod = null,
        public ?string $name = null
    ) {
        $this->regex = $this->compilePathToRegex($path);
    }

    /**
     * Convierte una ruta con parámetros dinámicos (como {id}) en una expresión regular
     * que puede usarse para hacer coincidir URLs.
     *
     * La función busca parámetros dinámicos dentro de llaves en el path de la ruta y los
     * reemplaza con un patrón de expresión regular que captura cualquier valor válido para esa
     * parte de la ruta. Los parámetros son considerados dinámicos cuando están dentro de llaves
     * (por ejemplo, {id} en "/users/{id}").
     *
     * Además, se garantiza que la expresión regular coincida con toda la URL, desde el inicio hasta
     * el final, gracias a los delimitadores de inicio (^) y fin ($).
     *
     * Ejemplo:
     * - Ruta de entrada: "/users/{id}"
     * - Expresión regular generada: "#^/users/([^/]+)$#"
     *
     * En este caso, el parámetro "{id}" es reemplazado por '([^/]+)', que captura cualquier valor
     * que no contenga barras (/). Esto permite que la ruta coincida con "/users/123", "/users/john",
     * o "/users/abc123", pero no con "/users/123/details".
     *
     * La función también permite manejar parámetros con restricciones de tipo, como
     * "{id<int>}", aunque en esta implementación no se hace la validación del tipo directamente.
     *
     * @param string $path El path de la ruta que puede contener parámetros dinámicos en llaves.
     * @return string La expresión regular generada que puede usarse para hacer coincidir la ruta.
     */
    private function compilePathToRegex(string $path): string
    {
        // Reemplaza los parámetros dinámicos entre llaves {param} por un patrón de expresión regular
        // que coincida con cualquier valor (excepto /).
        return '#^' . preg_replace('/\\{\\w+(<[^>]+>)?\\}/', '([^/]+)', $path) . '$#';
    }
}
