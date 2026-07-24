<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private PDO $db;


    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }


    /**
     * Find user by email address
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM users
             WHERE email = :email
             LIMIT 1"
        );

        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }


    /**
     * Find user by ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM users
             WHERE id = :id
             LIMIT 1"
        );

        $stmt->execute([
            'id' => $id
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }


    /**
     * Create new user
     */
    public function create(
        string $name,
        string $email,
        string $password,
        string $role = 'admin'
    ): int {

        $stmt = $this->db->prepare(
            "INSERT INTO users
            (
                name,
                email,
                password,
                role
            )
            VALUES
            (
                :name,
                :email,
                :password,
                :role
            )"
        );


        $stmt->execute([

            'name' => $name,

            'email' => $email,

            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),

            'role' => $role

        ]);


        return (int)$this->db->lastInsertId();
    }


    /**
     * Verify password
     */
    public function verifyPassword(
        string $password,
        string $hash
    ): bool {

        return password_verify(
            $password,
            $hash
        );
    }


    /**
     * Get all users
     */
    public function all(): array
    {
        $stmt = $this->db->query(
            "SELECT id, name, email, role, created_at
             FROM users
             ORDER BY created_at DESC"
        );


        return $stmt->fetchAll();
    }


    /**
     * Delete user
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM users
             WHERE id = :id"
        );


        return $stmt->execute([
            'id' => $id
        ]);
    }
}