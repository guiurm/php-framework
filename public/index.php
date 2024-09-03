<?php declare(strict_types=1);

use framework\Http\Request;

use function src\Kernel\dd;

require_once dirname(__DIR__).'/framework/kernel/autolad.php';


$req = Request::createFromGlobals();

dd($req);