<?php

namespace src\Controllers;

use framework\Attributes\Route;
use Framework\Http\JSONResponse;
use Framework\Http\RequestController;
use Framework\Http\Response;
use src\Models\User;

#[Route("user",  "/user",  "GET")]
class UserController extends RequestController
{

    #[Route(alias: "user.index", path: "/", method: "GET")]
    public function index(User $user, string $name, array $a)
    {
        $user->setEmail('test@domain.com');
        $user->setName('Random');
        return $this->render(__ROOT__ . '/src/Templates/UserProfile.php', ['user' => $user]);
    }

    #[Route(alias: "user.login", path: "/login", method: "GET")]
    public function login(User $user, string $name, array $a)
    {
        $user->setEmail('test@domain.com');
        $user->setName('Random');

        return new JSONResponse($user);
    }

    #[Route(alias: "user.register", path: "/register", method: ["GET", "POST"])]
    public function register(string $name)
    {
        return new Response("user.register" . " $name");
    }
}
