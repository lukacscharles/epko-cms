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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: users.php?error=not_found');
    exit;
}

$currentUser = Auth::user();

// Prevent user from deleting themselves
if ($currentUser && (int)$currentUser['id'] === $id) {
    header('Location: users.php?error=self_delete');
    exit;
}

$userModel = new User();
$targetUser = $userModel->findById($id);

if (!$targetUser) {
    header('Location: users.php?error=not_found');
    exit;
}

try {
    $userModel->delete($id);
    header('Location: users.php?success=deleted');
    exit;
} catch (\PDOException $e) {
    if (defined('APP_DEBUG') && APP_DEBUG) {
        die('Törlési hiba: ' . $e->getMessage());
    }

    header('Location: users.php?error=delete_failed');
    exit;
}
