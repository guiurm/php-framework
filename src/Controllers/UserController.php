<?php

namespace src\Controllers;

use framework\Attributes\Route;
use src\Models\User;

#[Route(alias: "user", path: "/user", method: "GET")]
class UserController
{

    #[Route(alias: "user.index", path: "/", method: "GET")]
    public function index(User $user, string $name) {}

    #[Route(alias: "user.index", path: "/login", method: "GET")]
    public function login(string $name) {}

    #[Route(alias: "user.index", path: "/register", method: ["GET", "POST"])]
    public function register(string $name) {}
}
