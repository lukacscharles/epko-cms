<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;


class Category
{

    private PDO $db;


    public function __construct()
    {
        $this->db = Database::connection();
    }



    /**
     * Get all categories
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





    /**
     * Count categories
     */
    public function count(): int
    {

        return (int) $this->db
            ->query(
                "SELECT COUNT(*) FROM categories"
            )
            ->fetchColumn();

    }





    /**
     * Create category
     */
    public function create(
        string $name,
        ?string $slug = null,
        int $sortOrder = 0
    ): bool {


        if ($slug === null) {

            $slug = $this->generateSlug($name);

        }



        $stmt = $this->db->prepare(
            "INSERT INTO categories
            (
                name,
                slug,
                sort_order
            )
            VALUES
            (
                :name,
                :slug,
                :sort_order
            )"
        );



        return $stmt->execute([

            'name' => $name,

            'slug' => $slug,

            'sort_order' => $sortOrder

        ]);

    }




        /**
     * search by ID
     */

        public function find(int $id): ?array
{
    $stmt = $this->db->prepare(
        "SELECT *
         FROM categories
         WHERE id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    $result = $stmt->fetch();

    return $result ?: null;
}

    /**
     * update
     */

    public function update(
    int $id,
    string $name,
    int $sortOrder,
    int $isActive
): bool {

    $stmt = $this->db->prepare(
        "UPDATE categories
         SET
            name = :name,
            sort_order = :sort_order,
            is_active = :is_active
         WHERE id = :id"
    );


    return $stmt->execute([

        'name' => $name,

        'sort_order' => $sortOrder,

        'is_active' => $isActive,

        'id' => $id

    ]);

}

    /**
     * delete
     */

public function delete(
    int $id
): bool {

    $stmt = $this->db->prepare(
        "DELETE FROM categories
         WHERE id = :id"
    );


    return $stmt->execute([
        'id' => $id
    ]);

}

    /**
     * Generate SEO friendly slug
     */
    private function generateSlug(
        string $text
    ): string {


        $text = iconv(
            'UTF-8',
            'ASCII//TRANSLIT',
            $text
        );


        $text = strtolower($text);



        $text = preg_replace(
            '/[^a-z0-9]+/',
            '-',
            $text
        );



        return trim(
            $text,
            '-'
        );

    }


}