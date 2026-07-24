<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
*/

define('APP_NAME', $_ENV['APP_NAME'] ?? 'EPKO Mini CMS');

define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

define(
    'APP_DEBUG',
    filter_var($_ENV['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN)
);

define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost');


/*
|--------------------------------------------------------------------------
| Upload Paths
|--------------------------------------------------------------------------
*/

define('UPLOAD_PATH', dirname(__DIR__, 2) . '/public/uploads/');

define('IMAGE_PATH', dirname(__DIR__, 2) . '/public/assets/images/');


/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

define('ITEMS_PER_PAGE', 12);


/*
|--------------------------------------------------------------------------
| Session Settings
|--------------------------------------------------------------------------
*/

define('SESSION_NAME', 'epko_admin_session');


/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

define('APP_TIMEZONE', 'Europe/Budapest');


/*CMS verzió: */

define('CMS_VERSION', '1.0.0');