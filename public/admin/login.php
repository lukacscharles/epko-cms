<?php

declare(strict_types=1);


require_once __DIR__ . '/../../app/Core/Bootstrap.php';


use App\Core\Auth;


/*
|--------------------------------------------------------------------------
| Already logged in?
|--------------------------------------------------------------------------
*/

if (Auth::check()) {

    header(
        'Location: dashboard.php'
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| Login handling
|--------------------------------------------------------------------------
*/

$error = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $email = trim(
        $_POST['email'] ?? ''
    );


    $password = $_POST['password'] ?? '';



    if (
        empty($email) ||
        empty($password)
    ) {

        $error = 'Minden mező kitöltése kötelező.';


    } else {


        $success = Auth::login(
            $email,
            $password
        );


        if ($success) {


            header(
                'Location: dashboard.php'
            );

            exit;


        } else {


            $error = 'Hibás email cím vagy jelszó.';


        }

    }

}

?>


<!DOCTYPE html>
<html lang="hu">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>
EPKO Mini CMS - Bejelentkezés
</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">


<style>

body {

    min-height: 100vh;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #f4f4f4;

}


.login-box {

    width: 100%;

    max-width: 420px;

}


.card {

    border-radius: 15px;

}


</style>


</head>


<body>


<div class="login-box">


<div class="card shadow">


<div class="card-body p-5">


<h2 class="text-center mb-4">

EPKO Mini CMS

</h2>


<p class="text-center text-muted">

Admin belépés

</p>



<?php if ($error): ?>


<div class="alert alert-danger">

<?= htmlspecialchars($error) ?>

</div>


<?php endif; ?>



<form method="POST">


<div class="mb-3">


<label class="form-label">

Email cím

</label>


<input 
    type="email"
    name="email"
    class="form-control"
    required
>


</div>



<div class="mb-3">


<label class="form-label">

Jelszó

</label>


<input 
    type="password"
    name="password"
    class="form-control"
    required
>


</div>



<button 
    type="submit"
    class="btn btn-primary w-100"
>

Belépés

</button>


</form>


</div>


</div>


</div>


</body>

</html>