<?php

namespace Src\Kernel;

$root = __DIR__;

$position = strpos(__DIR__, 'framework');

if ($position !== false)
    $root = substr(__DIR__, 0, $position);

define('__ROOT__', $root);
spl_autoload_register(function ($class_name) {

    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    require_once __ROOT__ . $file;
});

function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "<pre/>";
}
