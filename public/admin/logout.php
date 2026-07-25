<?php

declare(strict_types=1);


require_once __DIR__ . '/../../app/Core/Bootstrap.php';


use App\Core\Auth;
use App\Core\Csrf;


/*
|--------------------------------------------------------------------------
| Logout current user
|--------------------------------------------------------------------------
*/

Auth::logout();



/*
|--------------------------------------------------------------------------
| Redirect to login page
|--------------------------------------------------------------------------
*/

header(
    'Location: login.php'
);

exit;