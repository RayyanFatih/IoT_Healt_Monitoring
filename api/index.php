<?php

/**
 * Vercel PHP Entry Point for Laravel
 */

// Show ALL PHP errors so we can see what's crashing
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

// Vercel filesystem is read-only — redirect storage to /tmp
$tmpStorage = '/tmp/storage';
foreach ([
    "$tmpStorage/logs",
    "$tmpStorage/framework/cache/data",
    "$tmpStorage/framework/sessions",
    "$tmpStorage/framework/views",
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Check autoloader exists
$autoloader = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloader)) {
    http_response_code(500);
    die('ERROR: vendor/autoload.php not found. Composer install may have failed.');
}

require $autoloader;

$bootstrapFile = __DIR__ . '/../bootstrap/app.php';
if (!file_exists($bootstrapFile)) {
    http_response_code(500);
    die('ERROR: bootstrap/app.php not found.');
}

$app = require_once $bootstrapFile;

// Tell Laravel to use /tmp/storage instead of the read-only storage/
$app->useStoragePath($tmpStorage);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);

