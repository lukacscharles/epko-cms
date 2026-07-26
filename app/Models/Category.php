<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use App\Core\Database;

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }


    /*
    |--------------------------------------------------------------------------
    | Get all categories
    |--------------------------------------------------------------------------
    */

    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT *
            FROM categories
            ORDER BY sort_order ASC, name ASC"
        );

        return $stmt->fetchAll();
    }


    /*
    |--------------------------------------------------------------------------
    | Get category by ID
    |--------------------------------------------------------------------------
    */

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT *
            FROM categories
            WHERE id = :id
            LIMIT 1"
        );

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }


    /*
    |--------------------------------------------------------------------------
    | Count categories
    |--------------------------------------------------------------------------
    */

    public function count(): int
    {
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM categories")
            ->fetchColumn();
    }


    /*
    |--------------------------------------------------------------------------
    | Check if category exists
    |--------------------------------------------------------------------------
    */

    public function exists(string $name): bool
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*)
            FROM categories
            WHERE name = :name"
        );

        $stmt->execute([
            'name' => $name
        ]);

        return (bool) $stmt->fetchColumn();
    }


    /*
    |--------------------------------------------------------------------------
    | Create category
    |--------------------------------------------------------------------------
    */

    public function create(
        string $name,
        string $slug
    ): bool {

        $stmt = $this->db->prepare(
            "INSERT INTO categories
            (name, slug)
            VALUES
            (:name, :slug)"
        );

        return $stmt->execute([
            'name' => $name,
            'slug' => $slug
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update category
    |--------------------------------------------------------------------------
    */

    public function update(
        int $id,
        string $name,
        string $slug,
        int $sortOrder,
        bool $isActive
    ): bool {

        $stmt = $this->db->prepare(
            "UPDATE categories
            SET
                name = :name,
                slug = :slug,
                sort_order = :sort_order,
                is_active = :is_active
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'slug' => $slug,
            'sort_order' => $sortOrder,
            'is_active' => (int)$isActive
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete category
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM categories
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Get translations
    |--------------------------------------------------------------------------
    */

    public function getTranslations(int $categoryId): array
    {
        $stmt = $this->db->prepare(
            "SELECT *
            FROM category_translations
            WHERE category_id = :id
            ORDER BY language_code ASC"
        );

        $stmt->execute([
            'id' => $categoryId
        ]);

        return $stmt->fetchAll();
    }


    /*
    |--------------------------------------------------------------------------
    | Save translation
    |--------------------------------------------------------------------------
    */

    public function saveTranslation(
        int $categoryId,
        string $languageCode,
        string $translatedName
    ): bool {

        $stmt = $this->db->prepare(
            "REPLACE INTO category_translations
            (category_id, language_code, translated_name)
            VALUES
            (:category_id, :language_code, :translated_name)"
        );

        return $stmt->execute([
            'category_id'    => $categoryId,
            'language_code' => $languageCode,
            'translated_name' => $translatedName
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete translation
    |--------------------------------------------------------------------------
    */

    public function deleteTranslation(
        int $categoryId,
        string $languageCode
    ): bool {

        $stmt = $this->db->prepare(
            "DELETE FROM category_translations
            WHERE category_id = :category_id
            AND language_code = :language_code"
        );

        return $stmt->execute([
            'category_id' => $categoryId,
            'language_code' => $languageCode
        ]);
    }

}