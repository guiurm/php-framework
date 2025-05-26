<?php

namespace App\Controllers;

use Framework\Attributes\Route;
use Framework\Response;
use Framework\Routing\RouteBaseController;


#[Route(path: "/file")]
class FileController extends RouteBaseController
{
    public function __construct() {}

    #[Route(path: "/file", method: "GET", name: "file_get")]
    public function getFilePath(): Response
    {
        return new Response(content: '/var/www/html/uploads/');
    }

    #[Route(path: "/post", method: "POST", name: "file_upload")]
    public function getFileName(): string
    {
        return 'file.txt';
    }

    #[Route(path: "/put", method: "PUT", name: "file_update")]
    public function getFileType(): string
    {
        return 'txt';
    }
}
