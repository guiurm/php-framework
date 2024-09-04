<?php

declare(strict_types=1);

use Framework\DependencyInjector\DependencyInjectorClass;
use framework\Http\Request;
use Framework\Http\Router;
use Framework\Serializer\Deserializer;
use Framework\Serializer\JSONConverter;
use Framework\Serializer\Serializer;
use src\Controllers\UserController;

use src\Models\User;
use function src\Kernel\dd;

require_once dirname(__DIR__) . '/framework/kernel/autolad.php';

Router::manageRequest(Request::createFromGlobals());


$u = new User();
$u->setName('Juan');
$u->setEmail('jmail@mail.test');


$res = (new Serializer())->serialize($u, JSONConverter::getType());
//echo $res;


//dd(json_decode($res));
$res2 = (new Deserializer())->deserialize($res, JSONConverter::getType(), User::class);
dd($res2);
