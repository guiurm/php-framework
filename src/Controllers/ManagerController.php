<?php

namespace src\Controllers;

use framework\Attributes\Route;
use src\Models\User;

#[Route(alias: "manager", path: "/manager", method: "GET")]
class ManagerController
{

    #[Route(alias: "manager.index", path: "/", method: "GET")]
    public function index(User $manager, string $name) {}

    #[Route(alias: "manager.index", path: "/login", method: "GET")]
    public function login(string $name) {}

    #[Route(alias: "manager.index", path: "/register", method: ["GET", "POST"])]
    public function register(string $name) {}
}
