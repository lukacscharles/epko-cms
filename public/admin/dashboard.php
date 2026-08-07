<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/Core/Bootstrap.php';

use App\Core\Auth;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::requireLogin();


/*
|--------------------------------------------------------------------------
| Page Title
|--------------------------------------------------------------------------
*/

$pageTitle = 'Dashboard';


/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$totalImages = 0;
$totalCategories = 0;
$unreadMessages = 0;

$userModel = new User();
$totalUsers = $userModel->count();

$user = Auth::user();


/*
|--------------------------------------------------------------------------
| Layout
|--------------------------------------------------------------------------
*/

require_once 'partials/header.php';
require_once 'partials/sidebar.php';

?>

<div class="container-fluid py-4">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">

                Dashboard

            </h1>

            <p class="text-muted mb-0">

                Üdvözöllek az EPKO Mini CMS adminisztrációs felületén!

            </p>

        </div>

        <div>

            <a href="user-create.php" class="btn btn-primary me-2">

                <i class="bi bi-person-plus"></i>

                Új felhasználó hozzáadása

            </a>

            <a href="users.php" class="btn btn-outline-secondary">

                <i class="bi bi-people"></i>

                Felhasználók

            </a>

        </div>

    </div>


    <!-- Statistic Cards -->

    <div class="row g-4">

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>

                        Galéria képek

                    </h5>

                    <h2>

                        <?= $totalImages; ?>

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>

                        Kategóriák

                    </h5>

                    <h2>

                        <?= $totalCategories; ?>

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>

                        Új üzenetek

                    </h5>

                    <h2>

                        <?= $unreadMessages; ?>

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>

                        Felhasználók

                    </h5>

                    <h2>

                        <?= $totalUsers; ?>

                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- User Information -->

    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <h4>

                Bejelentkezett felhasználó

            </h4>

            <hr>

            <p>

                <strong>Név:</strong>

                <?= htmlspecialchars(
                    $user['name'] ?? '-',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </p>

            <p>

                <strong>Email:</strong>

                <?= htmlspecialchars(
                    $user['email'] ?? '-',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </p>

        </div>

    </div>


    <!-- Future Features -->

    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <h4>

                Következő modulok

            </h4>

            <hr>

            <ul>

                <li>Drag & Drop képfeltöltés</li>
                <li>Kategóriák kezelése</li>
                <li>Galéria menedzsment</li>
                <li>Kapcsolati üzenetek kezelése</li>
                <li>Oldalbeállítások</li>
                <li>One-page frontend szerkesztése</li>

            </ul>

        </div>

    </div>

</div>

<?php

require_once 'partials/footer.php';