<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    /**
     * Attempt to authenticate the user.
     */
    public static function login(
        string $email,
        string $password
    ): bool {

        $userModel = new User();

        $user = $userModel->findByEmail(
            $email
        );

        if (!$user) {

            return false;

        }


        if (
            !password_verify(
                $password,
                $user['password']
            )
        ) {

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | Regenerate session ID
        |--------------------------------------------------------------------------
        */

        session_regenerate_id(true);


        /*
        |--------------------------------------------------------------------------
        | Store user data in session
        |--------------------------------------------------------------------------
        */

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['last_activity'] = time();


        /*
        |--------------------------------------------------------------------------
        | Regenerate CSRF token
        |--------------------------------------------------------------------------
        */

        Csrf::regenerateToken();


        return true;
    }


    /**
     * Destroy the current session.
     */
    public static function logout(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Destroy CSRF token
        |--------------------------------------------------------------------------
        */

        Csrf::destroyToken();


        /*
        |--------------------------------------------------------------------------
        | Clear session data
        |--------------------------------------------------------------------------
        */

        $_SESSION = [];


        /*
        |--------------------------------------------------------------------------
        | Remove session cookie
        |--------------------------------------------------------------------------
        */

        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Destroy session
        |--------------------------------------------------------------------------
        */

        session_destroy();
    }


    /**
     * Check if the user is authenticated.
     */
    public static function check(): bool
    {
        if (
            !isset($_SESSION['user_id'])
        ) {

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | Session timeout
        |--------------------------------------------------------------------------
        */

        if (
            isset($_SESSION['last_activity'])
            &&
            (
                time() - $_SESSION['last_activity']
            ) > SESSION_LIFETIME
        ) {

            self::logout();

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | Update last activity timestamp
        |--------------------------------------------------------------------------
        */

        $_SESSION['last_activity'] = time();

        return true;
    }


    /**
     * Redirect guests to the login page.
     */
    public static function requireLogin(): void
    {
        if (!self::check()) {

            header(
                'Location: login.php'
            );

            exit;
        }
    }


    /**
     * Return the currently authenticated user.
     */
    public static function user(): ?array
    {
        if (!self::check()) {

            return null;

        }

        $userModel = new User();

        return $userModel->findById(
            (int) $_SESSION['user_id']
        );
    }


    /**
     * Return the current user's ID.
     */
    public static function id(): ?int
    {
        if (!self::check()) {

            return null;

        }

        return (int) $_SESSION['user_id'];
    }
}