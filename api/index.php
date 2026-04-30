<?php
// Minimal test — jika ini muncul, PHP berjalan di Vercel
echo "<h1>PHP Works!</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Extensions: pdo=" . (extension_loaded('pdo') ? 'yes' : 'NO') . ", pdo_pgsql=" . (extension_loaded('pdo_pgsql') ? 'yes' : 'NO') . "</p>";

// Cek vendor ada atau tidak
$vendorPath = __DIR__ . '/../vendor/autoload.php';
echo "<p>vendor/autoload.php exists: " . (file_exists($vendorPath) ? 'YES' : 'NO') . "</p>";
echo "<p>__DIR__: " . __DIR__ . "</p>";
echo "<p>realpath: " . realpath(__DIR__ . '/..') . "</p>";

