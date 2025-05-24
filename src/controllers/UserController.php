<?php

namespace App\Controllers;

use Framework\Response;
use Framework\Attributes\Route;
use Framework\Routing\RouteBaseController;

class UserController extends RouteBaseController
{
    #[Route(path: "/users/{id}", method: "GET", name: "user_show")]
    public function show(int $id): Response
    {
        //UserRepository $repo
        //    $user = $repo->find($id);
        return parent::jsonResponse(["id" => $id, "name" => "Usuario $id"]);
    }

    #[Route(path: "/users", method: "GET", name: "user_list")]
    public function list(): Response
    {
        return new Response("Lista de usuarios");
    }
}
