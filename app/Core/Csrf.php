<?php

declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    /**
     * Session key name.
     */
    private const TOKEN_NAME = 'csrf_token';


    /**
     * Generates a new CSRF token if one does not exist.
     */
    public static function generateToken(): void
    {
        if (!isset($_SESSION[self::TOKEN_NAME])) {

            $_SESSION[self::TOKEN_NAME] = bin2hex(
                random_bytes(32)
            );

        }
    }


    /**
     * Returns the current CSRF token.
     */
    public static function getToken(): string
    {
        self::generateToken();

        return $_SESSION[self::TOKEN_NAME];
    }


    /**
     * Returns a ready-to-use hidden input field.
     */
    public static function inputField(): string
    {
        $token = self::getToken();

        return sprintf(
            '<input type="hidden" name="_token" value="%s">',
            htmlspecialchars(
                $token,
                ENT_QUOTES,
                'UTF-8'
            )
        );
    }


    /**
     * Validates the submitted token.
     */
    public static function validateToken(
        ?string $submittedToken
    ): bool {

        if (
            empty($submittedToken) ||
            !isset($_SESSION[self::TOKEN_NAME])
        ) {

            return false;

        }

        return hash_equals(
            $_SESSION[self::TOKEN_NAME],
            $submittedToken
        );
    }


    /**
     * Regenerates the token.
     *
     * Useful after login/logout or sensitive actions.
     */
    public static function regenerateToken(): void
    {
        $_SESSION[self::TOKEN_NAME] = bin2hex(
            random_bytes(32)
        );
    }


    /**
     * Removes the token from the session.
     */
    public static function destroyToken(): void
    {
        unset(
            $_SESSION[self::TOKEN_NAME]
        );
    }
}