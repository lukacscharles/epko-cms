<?php

declare(strict_types=1);


/*
|--------------------------------------------------------------------------
| Application Bootstrap
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../app/Core/Bootstrap.php';


/*
|--------------------------------------------------------------------------
| Database Test
|--------------------------------------------------------------------------
*/

use App\Core\Database;

$dbStatus = false;
$dbMessage = '';

try {

    $database = Database::getInstance();

    $db = $database->getConnection();

    $dbStatus = true;

    $dbMessage = 'Database connection successful.';

} catch (Throwable $e) {

    $dbMessage = $e->getMessage();

}

?>

<!DOCTYPE html>
<html lang="hu">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_NAME ?></title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        code {
            background: #eee;
            padding: 3px 6px;
        }

    </style>

</head>


<body>

<div class="container">

    <h1><?= APP_NAME ?></h1>

    <h2>System Check</h2>


    <p>
        PHP Version:
        <strong><?= PHP_VERSION ?></strong>
    </p>


    <p>
        Environment:
        <strong><?= APP_ENV ?></strong>
    </p>


    <p>
        Database:

        <?php if ($dbStatus): ?>

            <span class="success">
                ✔ <?= $dbMessage ?>
            </span>

        <?php else: ?>

            <span class="error">
                ✖ <?= $dbMessage ?>
            </span>

        <?php endif; ?>

    </p>


    <hr>


    <p>
        CMS Version:
        <?= CMS_VERSION ?>
    </p>


</div>


</body>

</html>