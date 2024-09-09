<?php

namespace src\Controllers;

use framework\Attributes\Route;
use Framework\Http\RequestController;
use src\Models\User;


class ManagerController extends RequestController
{

    #[Route(alias: "manager.index", path: "/", method: "GET")]
    public function index()
    {
        echo "loaded";
    }

    #[Route(alias: "manager.login", path: "/login", method: "GET")]
    public function login(User $name)
    {
        $titulo = "Bienvenido a mi sitio";
        $contenido = "Este es el contenido de la página.";
        /*$a = $this->renderView(__ROOT__ . "/src/Templates/IndexView.php", [
            'titulo' => $titulo,
            'contenido' => $contenido
        ]);

        echo $a;*/

        return $this->render(__ROOT__ . "/src/Templates/IndexView.php", [
            'titulo' => $titulo,
            'contenido' => $contenido
        ]);
    }

    #[Route(alias: "manager.register", path: "/register", method: ["GET", "POST"])]
    public function register(string $name)
    {
        echo "manager.register";
    }
}
