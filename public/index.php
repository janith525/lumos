<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Force file drivers for /start, /clear, and /storage-create route initialization to avoid DB lookup loops
// Force file drivers for /start, /clear, and /storage-create route initialization to avoid DB lookup loops
if (isset($_SERVER['REQUEST_URI'])) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($path === '/start' || $path === '/clear' || $path === '/storage-create') {
        putenv('SESSION_DRIVER=file');
        putenv('CACHE_STORE=file');
        putenv('QUEUE_CONNECTION=sync');
        $_ENV['SESSION_DRIVER'] = 'file';
        $_ENV['CACHE_STORE'] = 'file';
        $_ENV['QUEUE_CONNECTION'] = 'sync';
        $_SERVER['SESSION_DRIVER'] = 'file';
        $_SERVER['CACHE_STORE'] = 'file';
        $_SERVER['QUEUE_CONNECTION'] = 'sync';
    }
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
