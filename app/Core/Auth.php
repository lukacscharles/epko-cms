<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

class Auth
{
    private static ?array $user = null;


    /**
     * Attempt login
     */
    public static function login(
        string $email,
        string $password
    ): bool {

        $userModel = new User();


        $user = $userModel->findByEmail($email);


        if (!$user) {
            return false;
        }


        if (
            !$userModel->verifyPassword(
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
        | Store user session
        |--------------------------------------------------------------------------
        */

        $_SESSION['user_id'] = $user['id'];

        $_SESSION['user_email'] = $user['email'];

        $_SESSION['user_role'] = $user['role'];

        $_SESSION['last_activity'] = time();


        self::$user = $user;


        return true;
    }



    /**
     * Logout user
     */
    public static function logout(): void
    {

        $_SESSION = [];


        if (ini_get("session.use_cookies")) {

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


        session_destroy();


        self::$user = null;
    }



    /**
     * Check if user is authenticated
     */
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }



    /**
     * Get current logged-in user
     */
    public static function user(): ?array
    {

        if (!self::check()) {

            return null;

        }


        if (self::$user !== null) {

            return self::$user;

        }


        $userModel = new User();


        self::$user = $userModel->findById(
            (int)$_SESSION['user_id']
        );


        return self::$user;
    }



    /**
     * Require authentication
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
     * Check user role
     */
    public static function hasRole(
        string $role
    ): bool {

        return isset($_SESSION['user_role'])
            &&
            $_SESSION['user_role'] === $role;

    }
}