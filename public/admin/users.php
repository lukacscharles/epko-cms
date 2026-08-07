<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/app/Core/Bootstrap.php';

use App\Core\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::requireLogin();

/*
|--------------------------------------------------------------------------
| Page settings
|--------------------------------------------------------------------------
*/

$pageTitle = 'Felhasználók';
$currentUser = Auth::user();

/*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
*/

$userModel = new User();
$users = $userModel->all();
$totalUsers = $userModel->count();

$successMessage = null;
$errorMessage = null;

if (isset($_GET['success'])) {
    if ($_GET['success'] === 'created') {
        $successMessage = 'Új felhasználó sikeresen létrehozva!';
    } elseif ($_GET['success'] === 'deleted') {
        $successMessage = 'A felhasználó sikeresen törölve lett!';
    }
}

if (isset($_GET['error'])) {
    if ($_GET['error'] === 'self_delete') {
        $errorMessage = 'A saját fiókodat nem törölheted!';
    } elseif ($_GET['error'] === 'not_found') {
        $errorMessage = 'A megadott felhasználó nem található.';
    } elseif ($_GET['error'] === 'csrf') {
        $errorMessage = 'Érvénytelen CSRF token.';
    }
}

/*
|--------------------------------------------------------------------------
| Layout
|--------------------------------------------------------------------------
*/

require_once 'partials/header.php';
require_once 'partials/sidebar.php';

?>

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">
                Felhasználók
            </h1>
            <p class="text-muted mb-0">
                Az adminisztrációs felület felhasználóinak kezelése.
            </p>
        </div>
        <div>
            <a href="user-create.php" class="btn btn-primary">
                <i class="bi bi-person-plus"></i>
                Új felhasználó
            </a>
        </div>
    </div>

    <!-- ALERTS -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- STATISTICS -->
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">
                        Összes felhasználó
                    </h6>
                    <h2>
                        <?= $totalUsers ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- USER LIST -->
    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            <i class="bi bi-people me-1"></i> Felhasználói fiókok
        </div>
        <div class="card-body">
            <?php if (empty($users)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-person-x fs-1 text-muted"></i>
                    <h3 class="mt-3">Nincs megjeleníthető felhasználó.</h3>
                    <a href="user-create.php" class="btn btn-primary mt-2">
                        Új felhasználó hozzáadása
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Név</th>
                                <th>E-mail</th>
                                <th>Szerepkör</th>
                                <th>Létrehozva</th>
                                <th class="text-end">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $u['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($u['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                                        <?php if ($currentUser && (int)$currentUser['id'] === (int)$u['id']): ?>
                                            <span class="badge bg-info text-dark ms-1">Aktív (Te)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($u['role'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($u['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="text-end">
                                        <?php if ($currentUser && (int)$currentUser['id'] !== (int)$u['id']): ?>
                                            <a href="user-delete.php?id=<?= $u['id'] ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Biztosan törölni szeretnéd ezt a felhasználót?');">
                                                <i class="bi bi-trash"></i> Törlés
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Saját fiók</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php
require_once 'partials/footer.php';
