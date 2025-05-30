<?php

declare(strict_types=1);

use Framework\Kernel\App\FrameworkKernel;

require_once __DIR__ . '/../Framework/autoload.php';

$kernel = new FrameworkKernel();

$kernel->handle();

die();
