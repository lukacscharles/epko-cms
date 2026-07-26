<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use App\Core\Database;

class GalleryImage
{
    private PDO $db;


    public function __construct()
    {
        $this->db = Database::connection();
        
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

    public function getByCategory(int $categoryId): array
    {
        $stmt = $this->db->prepare(
            "SELECT *
            FROM gallery_images
            WHERE category_id = :category_id
            ORDER BY sort_order ASC"
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
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM gallery_images")
            ->fetchColumn();
    }


    /*
    |--------------------------------------------------------------------------
    | Count featured images
    |--------------------------------------------------------------------------
    */

    public function countFeatured(): int
    {
        return (int) $this->db
            ->query(
                "SELECT COUNT(*)
                FROM gallery_images
                WHERE is_featured = 1"
            )
            ->fetchColumn();
    }


    /*
    |--------------------------------------------------------------------------
    | Create image
    |--------------------------------------------------------------------------
    */

    public function create(
        int $categoryId,
        string $filename,
        ?string $thumbnail = null
    ): bool {

        $stmt = $this->db->prepare(
            "INSERT INTO gallery_images
            (
                category_id,
                filename,
                thumbnail
            )
            VALUES
            (
                :category_id,
                :filename,
                :thumbnail
            )"
        );

        return $stmt->execute([
            'category_id' => $categoryId,
            'filename' => $filename,
            'thumbnail' => $thumbnail
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update image
    |--------------------------------------------------------------------------
    */

    public function update(
        int $id,
        int $categoryId,
        string $filename,
        ?string $thumbnail,
        int $sortOrder,
        bool $isFeatured,
        bool $isActive
    ): bool {

        $stmt = $this->db->prepare(
            "UPDATE gallery_images
            SET
                category_id = :category_id,
                filename = :filename,
                thumbnail = :thumbnail,
                sort_order = :sort_order,
                is_featured = :is_featured,
                is_active = :is_active
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'category_id' => $categoryId,
            'filename' => $filename,
            'thumbnail' => $thumbnail,
            'sort_order' => $sortOrder,
            'is_featured' => (int)$isFeatured,
            'is_active' => (int)$isActive
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete image
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): bool
    {
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
    | Set featured image
    |--------------------------------------------------------------------------
    */

    public function setFeatured(
        int $id,
        bool $featured
    ): bool {

        $stmt = $this->db->prepare(
            "UPDATE gallery_images
            SET is_featured = :featured
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'featured' => (int)$featured
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Set active / inactive
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
    | Get translations
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
        ?string $description = null,
        ?string $altText = null,
        ?string $seoTitle = null,
        ?string $seoDescription = null
    ): bool {

        $stmt = $this->db->prepare(
            "REPLACE INTO gallery_translations
            (
                gallery_id,
                language_code,
                title,
                description,
                alt_text,
                seo_title,
                seo_description
            )
            VALUES
            (
                :gallery_id,
                :language_code,
                :title,
                :description,
                :alt_text,
                :seo_title,
                :seo_description
            )"
        );

        return $stmt->execute([
            'gallery_id' => $galleryId,
            'language_code' => $languageCode,
            'title' => $title,
            'description' => $description,
            'alt_text' => $altText,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription
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