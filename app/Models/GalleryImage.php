<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;


class GalleryImage
{

    private PDO $db;



    public function __construct()
    {

        $this->db = Database::getInstance()
            ->getConnection();

    }



    /*
    |--------------------------------------------------------------------------
    | Get all images
    |--------------------------------------------------------------------------
    */

    public function getAll(): array
    {

        $stmt = $this->db->query(
            "SELECT *
             FROM gallery_images
             ORDER BY sort_order ASC, id DESC"
        );


        return $stmt->fetchAll();

    }





    /*
    |--------------------------------------------------------------------------
    | Get active images
    |--------------------------------------------------------------------------
    */

    public function getActive(): array
    {

        $stmt = $this->db->query(
            "SELECT *
             FROM gallery_images
             WHERE is_active = 1
             ORDER BY sort_order ASC, id DESC"
        );


        return $stmt->fetchAll();

    }





    /*
    |--------------------------------------------------------------------------
    | Get image by ID
    |--------------------------------------------------------------------------
    */

    public function getById(int $id): array|false
    {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM gallery_images
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
    | Get images by category
    |--------------------------------------------------------------------------
    */

    public function getByCategory(
        int $categoryId
    ): array {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM gallery_images
             WHERE category_id = :category_id
             ORDER BY sort_order ASC, id DESC"
        );


        $stmt->execute([
            'category_id' => $categoryId
        ]);


        return $stmt->fetchAll();

    }





    /*
    |--------------------------------------------------------------------------
    | Count images
    |--------------------------------------------------------------------------
    */

    public function count(): int
    {

        return (int)$this->db
            ->query(
                "SELECT COUNT(*)
                 FROM gallery_images"
            )
            ->fetchColumn();

    }





    /*
    |--------------------------------------------------------------------------
    | Create image
    |--------------------------------------------------------------------------
    */

    public function create(
        array $data
    ): bool {

        $stmt = $this->db->prepare(
            "INSERT INTO gallery_images
            (
                category_id,
                title,
                description,
                alt_text,
                image,
                sort_order,
                is_active
            )
            VALUES
            (
                :category_id,
                :title,
                :description,
                :alt_text,
                :image,
                :sort_order,
                :is_active
            )"
        );


        return $stmt->execute([

            'category_id' => $data['category_id'],

            'title' => $data['title'],

            'description' => $data['description'],

            'alt_text' => $data['alt_text'] ?? null,

            'image' => $data['image'],

            'sort_order' => $data['sort_order'] ?? 0,

            'is_active' => $data['is_active'] ?? 1

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Update image
    |--------------------------------------------------------------------------
    */

    public function update(
        int $id,
        array $data
    ): bool {


        $stmt = $this->db->prepare(
            "UPDATE gallery_images
             SET

                category_id = :category_id,

                title = :title,

                description = :description,

                alt_text = :alt_text,

                image = :image,

                sort_order = :sort_order,

                is_active = :is_active

             WHERE id = :id"
        );


        return $stmt->execute([


            'id' => $id,


            'category_id' => $data['category_id'],


            'title' => $data['title'],


            'description' => $data['description'],


            'alt_text' => $data['alt_text'] ?? null,


            'image' => $data['image'],


            'sort_order' => $data['sort_order'] ?? 0,


            'is_active' => $data['is_active'] ?? 1

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Delete image
    |--------------------------------------------------------------------------
    */

    public function delete(
        int $id
    ): bool {

        $stmt = $this->db->prepare(
            "DELETE FROM gallery_images
             WHERE id = :id"
        );


        return $stmt->execute([

            'id' => $id

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Activate / deactivate image
    |--------------------------------------------------------------------------
    */

    public function setActive(
        int $id,
        bool $active
    ): bool {

        $stmt = $this->db->prepare(
            "UPDATE gallery_images
             SET is_active = :active
             WHERE id = :id"
        );


        return $stmt->execute([

            'id' => $id,

            'active' => (int)$active

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Translation list
    |--------------------------------------------------------------------------
    */

    public function getTranslations(
        int $galleryId
    ): array {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM gallery_translations
             WHERE gallery_id = :gallery_id
             ORDER BY language_code ASC"
        );


        $stmt->execute([

            'gallery_id' => $galleryId

        ]);


        return $stmt->fetchAll();

    }





    /*
    |--------------------------------------------------------------------------
    | Save translation
    |--------------------------------------------------------------------------
    */

    public function saveTranslation(
        int $galleryId,
        string $languageCode,
        string $title,
        string $description,
        ?string $altText = null
    ): bool {


        $stmt = $this->db->prepare(
            "REPLACE INTO gallery_translations
            (
                gallery_id,
                language_code,
                title,
                description,
                alt_text
            )
            VALUES
            (
                :gallery_id,
                :language_code,
                :title,
                :description,
                :alt_text
            )"
        );


        return $stmt->execute([

            'gallery_id' => $galleryId,

            'language_code' => $languageCode,

            'title' => $title,

            'description' => $description,

            'alt_text' => $altText

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Delete translation
    |--------------------------------------------------------------------------
    */

    public function deleteTranslation(
        int $galleryId,
        string $languageCode
    ): bool {


        $stmt = $this->db->prepare(
            "DELETE FROM gallery_translations
             WHERE gallery_id = :gallery_id
             AND language_code = :language_code"
        );


        return $stmt->execute([

            'gallery_id' => $galleryId,

            'language_code' => $languageCode

        ]);

    }


}