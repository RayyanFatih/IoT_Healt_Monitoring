<?php

/**
 * Vercel PHP Entry Point for Laravel
 * Semua request dari Vercel diteruskan ke Laravel melalui file ini.
 */

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

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Tell Laravel to use /tmp/storage instead of the read-only storage/
$app->useStoragePath($tmpStorage);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);

