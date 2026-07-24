<?php

declare(strict_types=1);

use Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| Composer Autoloader
|--------------------------------------------------------------------------
*/

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';


/*
|--------------------------------------------------------------------------
| Environment Variables (.env)
|--------------------------------------------------------------------------
*/

$dotenv = Dotenv::createImmutable(
    dirname(__DIR__, 2)
);

$dotenv->safeLoad();


/*
|--------------------------------------------------------------------------
| Application Configuration
|--------------------------------------------------------------------------
*/

require_once dirname(__DIR__) . '/Config/config.php';


/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set(APP_TIMEZONE);


/*
|--------------------------------------------------------------------------
| Error Reporting
|--------------------------------------------------------------------------
*/

if (APP_DEBUG) {

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    error_reporting(E_ALL);

} else {

    ini_set('display_errors', '0');
    error_reporting(0);

}


/*
|--------------------------------------------------------------------------
| Session Security
|--------------------------------------------------------------------------
*/

ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');

/*
|--------------------------------------------------------------------------
| SameSite cookie protection
|--------------------------------------------------------------------------
|
| Possible values:
| - Strict
| - Lax
| - None
|
*/

ini_set(
    'session.cookie_samesite',
    'Strict'
);


/*
|--------------------------------------------------------------------------
| Session Lifetime
|--------------------------------------------------------------------------
*/

ini_set(
    'session.gc_maxlifetime',
    (string) SESSION_LIFETIME
);


/*
|--------------------------------------------------------------------------
| Session Initialization
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {

    session_name(SESSION_NAME);

    session_start();

}


/*
|--------------------------------------------------------------------------
| Disable Browser Cache for Logged In Users
|--------------------------------------------------------------------------
|
| Prevents the browser from showing previously cached
| admin pages after logout.
|
*/

if (isset($_SESSION['user_id'])) {

    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

}


/*
|--------------------------------------------------------------------------
| Future Application Boot
|--------------------------------------------------------------------------
|
| Possible future initializers:
|
| Auth::boot();
| Csrf::boot();
| Router::boot();
| Logger::boot();
| Cache::boot();
|
*/