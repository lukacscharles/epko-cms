<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/app/Core/Bootstrap.php';

use App\Core\Auth;
use App\Core\Csrf;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::requireLogin();

$pageTitle = 'Új felhasználó hozzáadása';
$userModel = new User();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Check
    if (!Csrf::validateToken($_POST['_token'] ?? null)) {
        die('Érvénytelen CSRF token.');
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $role = trim($_POST['role'] ?? 'admin');

    // Name Validation
    if ($name === '') {
        $errors[] = 'A felhasználónév megadása kötelező.';
    } elseif (mb_strlen($name) > 50) {
        $errors[] = 'A felhasználónév maximum 50 karakter lehet.';
    } elseif ($userModel->findByName($name) !== null) {
        $errors[] = 'Ez a felhasználónév már foglalt.';
    }

    // Email Validation
    if ($email === '') {
        $errors[] = 'Az e-mail cím megadása kötelező.';
    } elseif (mb_strlen($email) > 100) {
        $errors[] = 'Az e-mail cím maximum 100 karakter lehet.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Érvénytelen e-mail cím formátum.';
    } elseif ($userModel->findByEmail($email) !== null) {
        $errors[] = 'Ez az e-mail cím már regisztrálva van.';
    }

    // Password Validation
    if ($password === '') {
        $errors[] = 'A jelszó megadása kötelező.';
    } elseif (mb_strlen($password) < 6) {
        $errors[] = 'A jelszónak legalább 6 karakter hosszúnak kell lennie.';
    }

    if ($password !== $passwordConfirm) {
        $errors[] = 'A megadott jelszavak nem egyeznek.';
    }

    // Role Validation
    if ($role !== 'admin') {
        $role = 'admin';
    }

    if (empty($errors)) {
        try {
            $userModel->create(
                $name,
                $email,
                $password,
                $role
            );

            Csrf::regenerateToken();

            header('Location: users.php?success=created');
            exit;

        } catch (\PDOException $e) {
            if (defined('APP_DEBUG') && APP_DEBUG) {
                die('Adatbázis hiba: ' . $e->getMessage());
            }

            $errors[] = 'Hiba történt a felhasználó mentése során.';
        }
    }
}

require_once 'partials/header.php';
require_once 'partials/sidebar.php';

?>

<div class="container-fluid py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                Új felhasználó hozzáadása
            </h1>
            <p class="text-muted mb-0">
                Hozz létre egy új adminisztrátori fiókot a rendszerben.
            </p>
        </div>

        <a href="users.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Vissza a felhasználókhoz
        </a>
    </div>

    <!-- ERROR ALERTS -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger shadow-sm">
            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Kérjük javítsd az alábbi hibákat:
            </div>
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- CREATE USER FORM CARD -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    <i class="bi bi-person-plus me-1"></i> Felhasználói adatok
                </div>
                <div class="card-body">
                    <form method="POST" action="user-create.php">

                        <?= Csrf::inputField() ?>

                        <div class="mb-3">
                            <label for="name" class="form-label font-weight-bold">
                                Felhasználónév <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control"
                                   maxlength="50"
                                   required
                                   value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                   placeholder="pl. kovacs_janos">
                            <div class="form-text">A felhasználó azonosítója a rendszerben (maximum 50 karakter).</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                E-mail cím <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control"
                                   maxlength="100"
                                   required
                                   value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                   placeholder="pl. janos@example.com">
                            <div class="form-text">A bejelentkezéshez és értesítésekhez használt e-mail cím.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Jelszó <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control"
                                       minlength="6"
                                       required
                                       placeholder="••••••••">
                                <div class="form-text">Legalább 6 karakter. Hashelt formában tárolódik az adatbázisban.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirm" class="form-label">
                                    Jelszó megerősítése <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       id="password_confirm"
                                       name="password_confirm"
                                       class="form-control"
                                       minlength="6"
                                       required
                                       placeholder="••••••••">
                                <div class="form-text">Írd be újra a megadott jelszót.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">
                                Szerepkör
                            </label>
                            <select id="role" name="role" class="form-select">
                                <option value="admin" selected>Adminisztrátor</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                Felhasználó mentése
                            </button>

                            <a href="users.php" class="btn btn-secondary">
                                Mégse
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
require_once 'partials/footer.php';
