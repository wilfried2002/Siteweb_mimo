<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-detect : local (public/ = sous-dossier) ou cPanel (public_html/ = racine)
$root = file_exists(__DIR__ . '/../vendor/autoload.php')
    ? __DIR__ . '/..'
    : __DIR__;

// Maintenance mode
if (file_exists($maintenance = $root . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $root . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $root . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
