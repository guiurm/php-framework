<?php

function pre($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

spl_autoload_register(function ($clase) {
    // Eliminar el namespace raíz (ej. "App\") si quieres restringir

    $namespaces = [
        'App' => 'src',
        'Framework' => 'Framework',
    ];
    // pre("Namespace: $clase");

    foreach ($namespaces as $namespace => $directory) {
        if (strpos($clase, $namespace . '\\') === 0) {
            // Reemplaza el namespace raíz por el directorio correspondiente
            $clase = $directory . str_replace('\\', '/', substr($clase, strlen($namespace)));
            break;
        }
    }


    $baseDir = __DIR__ . '/../';
    // pre("Base dir: $baseDir");

    // pre("Cargando clase: $clase");

    // pre('-------------------------------------');

    // Convertir namespace en ruta
    $ruta = $baseDir . str_replace('\\', '/', $clase) . '.php';

    if (file_exists($ruta)) {
        require_once $ruta;
    } else {
        echo "No se encontró la clase: $ruta\n";
    }
});
