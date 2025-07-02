<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists(__DIR__ . '/storage/framework/maintenance.php')) {
    require __DIR__ . '/storage/framework/maintenance.php';
}

// Autoload
require __DIR__ . '/vendor/autoload.php';

// Bootstrap
$app = require_once __DIR__ . '/bootstrap/app.php';

// Handle the request
$app->handleRequest(Request::capture());
