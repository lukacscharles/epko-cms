<?php

declare(strict_types=1);


require_once __DIR__ . '/../../app/Core/Bootstrap.php';


use App\Core\Auth;


/*
|--------------------------------------------------------------------------
| Authentication check
|--------------------------------------------------------------------------
*/

Auth::requireLogin();


/*
|--------------------------------------------------------------------------
| Current user
|--------------------------------------------------------------------------
*/

$user = Auth::user();

?>


<!DOCTYPE html>
<html lang="hu">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>
EPKO Mini CMS - Dashboard
</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">


<style>

body {

    background: #f5f6fa;

}


.sidebar {

    min-height: 100vh;

}


.nav-link {

    color: #fff;

}


.nav-link:hover {

    background: rgba(255,255,255,.1);

}


.card {

    border-radius: 15px;

}


</style>


</head>


<body>


<div class="container-fluid">


<div class="row">


<!-- Sidebar -->

<div class="col-md-3 col-lg-2 bg-dark sidebar p-3">


<h4 class="text-white mb-4">

EPKO CMS

</h4>



<ul class="nav flex-column">


<li class="nav-item mb-2">

<a href="dashboard.php"
   class="nav-link">

Dashboard

</a>

</li>



<li class="nav-item mb-2">

<a href="#"
   class="nav-link">

Képgaléria

</a>

</li>



<li class="nav-item mb-2">

<a href="#"
   class="nav-link">

Kategóriák

</a>

</li>



<li class="nav-item mb-2">

<a href="#"
   class="nav-link">

Üzenetek

</a>

</li>



<li class="nav-item mt-4">


<a href="logout.php"
   class="btn btn-danger w-100">

Kijelentkezés

</a>


</li>


</ul>


</div>



<!-- Main content -->

<div class="col-md-9 col-lg-10 p-4">



<div class="d-flex justify-content-between align-items-center mb-4">


<h1>

Dashboard

</h1>



<div>

Üdv,

<strong>

<?= htmlspecialchars($user['name']) ?>

</strong>

</div>


</div>





<div class="row g-4">



<div class="col-md-4">


<div class="card shadow-sm">


<div class="card-body">


<h5>

Képek

</h5>


<p class="text-muted">

Galéria kezelése

</p>


<a href="#"
   class="btn btn-primary">

Megnyitás

</a>


</div>


</div>


</div>





<div class="col-md-4">


<div class="card shadow-sm">


<div class="card-body">


<h5>

Kategóriák

</h5>


<p class="text-muted">

Tartalmi kategóriák kezelése

</p>


<a href="#"
   class="btn btn-primary">

Megnyitás

</a>


</div>


</div>


</div>





<div class="col-md-4">


<div class="card shadow-sm">


<div class="card-body">


<h5>

Üzenetek

</h5>


<p class="text-muted">

Kapcsolati űrlap üzenetek

</p>


<a href="#"
   class="btn btn-primary">

Megnyitás

</a>


</div>


</div>


</div>



</div>



<hr class="my-5">



<div class="card shadow-sm">


<div class="card-body">


<h4>

Rendszer információ

</h4>


<table class="table">


<tr>

<td>

CMS verzió

</td>

<td>

1.0.0

</td>

</tr>



<tr>

<td>

Felhasználó

</td>

<td>

<?= htmlspecialchars($user['email']) ?>

</td>

</tr>



<tr>

<td>

Jogosultság

</td>

<td>

<?= htmlspecialchars($user['role']) ?>

</td>

</tr>


</table>


</div>


</div>



</div>


</div>


</div>



</body>

</html>