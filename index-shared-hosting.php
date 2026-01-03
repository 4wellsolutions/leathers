<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// IMPORTANT: Adjust this path to point to your Laravel installation outside public_html
// Example paths:
// - If Laravel is in /home/username/laravel-app, use: __DIR__.'/../laravel-app'
// - If Laravel is in /home/username/domains/new.leathers.pk/laravel, use: __DIR__.'/../laravel'
$laravelPath = __DIR__.'/../laravel-app';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $laravelPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $laravelPath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $laravelPath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
