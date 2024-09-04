<?php

namespace Framework\Http;

use Exception;
use framework\Attributes\Route;
use Framework\DependencyInjector\DependencyInjectorClass;
use ReflectionClass;
use src\Controllers\UserController;

use function Src\Kernel\dd;

function obtenerNamespaceDesdeArchivo($rutaArchivo)
{
    // Verifica si el archivo existe
    if (!file_exists($rutaArchivo)) {
        throw new Exception("El archivo no existe: " . $rutaArchivo);
    }

    // Obtiene el contenido del archivo
    $content = file_get_contents($rutaArchivo);
    $namespacePosition = strpos($content, 'namespace ');
    $namespaceLength = strlen('namespace ');
    $tailingComaPosition = strpos($content, ';');
    $namspace = substr($content, $namespacePosition + $namespaceLength, $tailingComaPosition - $namespacePosition - $namespaceLength);

    $classPosition = strpos($content, 'class ');
    $classpaceLength = strlen('class ');
    $braComaPosition = strpos($content, '{');

    $c = substr($content, $classPosition + $classpaceLength, $braComaPosition - $classPosition - $classpaceLength);

    return trim($namspace . '\\' . $c);
}

class Router
{
    public static function manageRequest(Request $request)
    {
        //dd($request);
        //echo $request->getUri();


        foreach (glob(__ROOT__ . "src/Controllers/*.php") as $filename) {
            $namespace = obtenerNamespaceDesdeArchivo($filename);
            $id = new DependencyInjectorClass($namespace);
            dd($id->getClassAttributes()[Route::class]->getArguments()['path']);
        }
    }
}


// Ejemplo de uso
