<?php

namespace Src\Kernel;

// /framework/Kernel/autoload.php
$root = __DIR__;

$position = strpos(__DIR__, 'framework');

if ($position !== false) {
    $root = substr(__DIR__, 0, $position);
}

define('__ROOT__', $root);

spl_autoload_register(function ($class_name) {
    // Convertimos el namespace a una ruta de archivo
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';

    // Intentamos incluir el archivo
    $full_path = __ROOT__ . DIRECTORY_SEPARATOR . $file;

    if (file_exists($full_path)) {
        require_once $full_path;
    } else {
        throw new \RuntimeException("Unable to load class: $class_name. File not found: $full_path");
    }
});

// Manejo de excepciones global
set_exception_handler(function ($exception) {
    echo "Error: " . $exception->getMessage();
});


function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "<pre/>";
}
