<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

if (!session_id()) {
    session_start();
}

// if ($_GET["php_info"]) {
    echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";
    echo phpinfo();
    exit;
// }

// Instantiate the app
$settings = require __DIR__.'/../app/settings.php';
$app      = new \Slim\App($settings);

// Set up dependencies
require __DIR__.'/../app/dependencies.php';

// Register middleware
require __DIR__.'/../app/middleware.php';

// Register routes
require __DIR__.'/../app/routes.php';

// Run!
$app->run();
