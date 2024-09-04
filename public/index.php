<?php

declare(strict_types=1);

use Framework\DependencyInjector\DependencyInjectorClass;
use framework\Http\Request;
use Framework\Http\Router;
use src\Controllers\UserController;

use function src\Kernel\dd;

require_once dirname(__DIR__) . '/framework/kernel/autolad.php';

Router::manageRequest(Request::createFromGlobals());
