<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Application
|--------------------------------------------------------------------------
*/

define(
    'APP_NAME',
    $_ENV['APP_NAME'] ?? 'EPKO Mini CMS'
);

define(
    'APP_ENV',
    $_ENV['APP_ENV'] ?? 'production'
);

define(
    'APP_DEBUG',
    filter_var(
        $_ENV['APP_DEBUG'] ?? false,
        FILTER_VALIDATE_BOOLEAN
    )
);

define(
    'APP_URL',
    $_ENV['APP_URL'] ?? ''
);

define(
    'APP_TIMEZONE',
    $_ENV['APP_TIMEZONE'] ?? 'Europe/Budapest'
);


/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/

define(
    'SESSION_NAME',
    $_ENV['SESSION_NAME'] ?? 'EPKO_SESSION'
);

define(
    'SESSION_LIFETIME',
    (int) ($_ENV['SESSION_LIFETIME'] ?? 7200)
);


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

define(
    'DB_HOST',
    $_ENV['DB_HOST'] ?? 'localhost'
);

define(
    'DB_PORT',
    $_ENV['DB_PORT'] ?? '3306'
);

define(
    'DB_DATABASE',
    $_ENV['DB_DATABASE'] ?? ''
);

define(
    'DB_USERNAME',
    $_ENV['DB_USERNAME'] ?? ''
);

define(
    'DB_PASSWORD',
    $_ENV['DB_PASSWORD'] ?? ''
);