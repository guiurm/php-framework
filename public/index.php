<?php

declare(strict_types=1);

use Framework\DependencyInjector\DependencyInjectorClass;
use framework\Http\Request;
use Framework\Http\Router;
use src\Controllers\UserController;

use function src\Kernel\dd;

require_once dirname(__DIR__) . '/framework/kernel/autolad.php';


//$req = Request::createFromGlobals();
//$id = new DependencyInjectorClass(UserController::class);
//$att = $id->getClassAttributes();
//dd($id->getMethods());

Router::manageRequest(Request::createFromGlobals());
