<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/Core/Bootstrap.php';

use App\Models\User;

$userModel = new User();

$adminExists = false;

/*
|--------------------------------------------------------------------------
| Check if an admin user already exists
|--------------------------------------------------------------------------
*/

$admins = array_filter(
    $userModel->all(),
    fn ($user) => $user['role'] === 'admin'
);

if (!empty($admins)) {
    $adminExists = true;
}


/*
|--------------------------------------------------------------------------
| Create first admin user
|--------------------------------------------------------------------------
*/

$message = '';

if (
    !$adminExists &&
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (
        empty($name) ||
        empty($email) ||
        empty($password)
    ) {

        $message = 'Minden mező kitöltése kötelező.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = 'Hibás e-mail cím.';

    } else {

        $existingUser = $userModel->findByEmail($email);

        if ($existingUser) {

            $message = 'Ez az e-mail cím már használatban van.';

        } else {

            $userModel->create(
                $name,
                $email,
                $password,
                'admin'
            );

            $message = 'Az admin felhasználó sikeresen létrejött.';

            $adminExists = true;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="hu">

<head>

    <meta charset="UTF-8">

    <title>EPKO Mini CMS - Telepítő</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <style>

        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

        .message {
            margin-bottom: 20px;
            font-weight: bold;
        }

    </style>

</head>

<body>


<h1>EPKO Mini CMS</h1>

<h2>Első admin felhasználó létrehozása</h2>


<?php if (!empty($message)) : ?>

    <p class="message">
        <?= htmlspecialchars($message) ?>
    </p>

<?php endif; ?>


<?php if ($adminExists) : ?>

    <p>
        Már létezik admin felhasználó.
    </p>

    <p>
        Biztonsági okokból nevezd át vagy töröld az
        <strong>install.php</strong> fájlt.
    </p>

<?php else : ?>


<form method="POST">

    <label>Név</label>

    <input
        type="text"
        name="name"
        required
    >


    <label>E-mail cím</label>

    <input
        type="email"
        name="email"
        required
    >


    <label>Jelszó</label>

    <input
        type="password"
        name="password"
        minlength="8"
        required
    >


    <button type="submit">

        Admin létrehozása

    </button>

</form>


<?php endif; ?>


</body>
</html>