<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Maintenance Mode: Look in ../blog_core/storage...
if (file_exists($maintenance = __DIR__.'/../../blog_core/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Autoloader: Look in ../blog_core/vendor...
require __DIR__.'/../../blog_core/vendor/autoload.php';

// 3. Bootstrap App: Look in ../blog_core/bootstrap...
/** @var Application $app */
$app = require_once __DIR__.'/../../blog_core/bootstrap/app.php';

$app->handleRequest(Request::capture());