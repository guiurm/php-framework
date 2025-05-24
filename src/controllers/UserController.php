<?php

namespace App\Controllers;

use Framework\Response;
use Framework\Attributes\Route;

class UserController
{
    #[Route(path: "/users/{id}", method: "GET", name: "user_show")]
    public function show(int $id): Response
    {
        //UserRepository $repo
        //    $user = $repo->find($id);
        return new Response("Usuario: $id");
    }

    #[Route(path: "/users", method: "GET", name: "user_list")]
    public function list(): Response
    {
        return new Response("Lista de usuarios");
    }
}
