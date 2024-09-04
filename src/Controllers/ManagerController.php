<?php

namespace src\Controllers;

use framework\Attributes\Route;
use src\Models\User;

class ManagerController
{

    #[Route(alias: "manager.index", path: "/", method: "GET")]
    public function index()
    {
        echo "loaded";
    }

    #[Route(alias: "manager.login", path: "/login", method: "GET")]
    public function login(string $name)
    {
        echo "manager.login";
    }

    #[Route(alias: "manager.register", path: "/register", method: ["GET", "POST"])]
    public function register(string $name)
    {
        echo "manager.register";
    }
}
