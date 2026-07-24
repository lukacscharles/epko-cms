<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    /**
     * Private constructor.
     */
    private function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE']
        );

        try {

            $this->connection = new PDO(
                $dsn,
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                self::getOptions()
            );

        } catch (PDOException $e) {

            if (APP_DEBUG) {
                die('Database connection failed: ' . $e->getMessage());
            }

            die('Database connection failed.');
        }
    }

    /**
     * Prevent cloning.
     */
    private function __clone()
    {
    }

    /**
     * Returns the Database singleton instance.
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Returns the PDO connection.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * PDO configuration options.
     */
    private static function getOptions(): array
    {
        return [

            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            PDO::ATTR_EMULATE_PREPARES => false,

        ];
    }

    /**
     * Starts a transaction.
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits the current transaction.
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction.
     */
    public function rollback(): bool
    {
        return $this->connection->rollBack();
    }
}
