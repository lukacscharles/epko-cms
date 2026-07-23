<?php

declare(strict_types=1);

use Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| Composer Autoload
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load Environment Variables
|--------------------------------------------------------------------------
*/

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

/*
|--------------------------------------------------------------------------
| Application Settings
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Europe/Budapest');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Error Reporting
|--------------------------------------------------------------------------
*/

if ($_ENV['APP_DEBUG'] === 'true') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}