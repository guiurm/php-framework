<?php

namespace src\Controllers;

use framework\Attributes\Route;
use Framework\Http\RequestController;
use src\Models\User;

#[Route("user",  "/user",  "GET")]
class UserController extends RequestController
{

    #[Route(alias: "user.index", path: "/", method: "GET")]
    public function index(User $user, string $name, array $a)
    {
        echo "user.index";
    }

    #[Route(alias: "user.login", path: "/login", method: "GET")]
    public function login(string $name)
    {
        echo "user.login";
    }

    #[Route(alias: "user.register", path: "/register", method: ["GET", "POST"])]
    public function register(string $name)
    {
        echo "user.register";
    }
}
