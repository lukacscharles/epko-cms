<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/app/Core/Bootstrap.php';

use App\Core\Auth;
use App\Models\Category;
use App\Models\GalleryImage;



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::requireLogin();


/*
|--------------------------------------------------------------------------
| Page settings
|--------------------------------------------------------------------------
*/

$pageTitle = 'Galéria';


/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
*/

$galleryModel = new GalleryImage();
$categoryModel = new Category();


/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$totalImages = $galleryModel->count();
$totalFeaturedImages = $galleryModel->countFeatured();
$totalCategories = $categoryModel->count();


/*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
*/

$images = $galleryModel->getAll();
$categories = $categoryModel->getAll();


/*
|--------------------------------------------------------------------------
| Layout
|--------------------------------------------------------------------------
*/

require_once 'partials/header.php';
require_once 'partials/sidebar.php';

?>


<div class="container-fluid py-4">

    <!-- PAGE HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="mb-1">
                Galéria kezelése
            </h1>

            <p class="text-muted mb-0">
                A referenciafotók és galéria elemek kezelése.
            </p>

        </div>

        <div>

            <a href="upload.php"
               class="btn btn-primary">

                <i class="bi bi-cloud-arrow-up-fill"></i>
                Kép feltöltése

            </a>

        </div>

    </div>


    <!-- STATISTICS -->

    <div class="row mb-5">

        <div class="col-lg-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Összes kép
                    </h6>

                    <h2>
                        <?= $totalImages ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-lg-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Kiemelt képek
                    </h6>

                    <h2>
                        <?= $totalFeaturedImages ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-lg-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Kategóriák
                    </h6>

                    <h2>
                        <?= $totalCategories ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- FILTERS -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Keresés
                    </label>

                    <input
                            type="text"
                            class="form-control"
                            placeholder="Kép címe..."
                    >

                </div>


                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Kategória
                    </label>

                    <select class="form-select">

                        <option selected>
                            Összes kategória
                        </option>

                        <?php foreach ($categories as $category): ?>

                            <option>

                                <?= htmlspecialchars(
                                    $category['name']
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Nyelv
                    </label>

                    <select class="form-select">

                        <option>Összes</option>
                        <option>HU</option>
                        <option>EN</option>
                        <option>IT</option>
                        <option>ES</option>
                        <option>ZH</option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    <!-- EMPTY STATE -->

    <?php if (empty($images)): ?>

        <div class="card shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-images fs-1"></i>

                <h3 class="mt-3">

                    Még nem töltöttél fel képet.

                </h3>

                <p class="text-muted">

                    Kezdd el felépíteni a referencia galériát.

                </p>

                <a href="upload.php"
                   class="btn btn-primary mt-2">

                    Első kép feltöltése

                </a>

            </div>

        </div>

    <?php else: ?>


        <!-- GALLERY GRID -->

        <div class="row g-4">

            <?php foreach ($images as $image): ?>

                <div class="col-lg-4 col-md-6">

                    <div class="card shadow-sm h-100">

                        <!-- THUMBNAIL -->

                        <?php if (!empty($image['thumbnail'])): ?>

                            <img
                                    src="../uploads/thumbnails/<?= htmlspecialchars($image['thumbnail']) ?>"
                                    class="card-img-top"
                                    alt="Thumbnail"
                            >

                        <?php else: ?>

                            <img
                                    src="../uploads/<?= htmlspecialchars($image['filename']) ?>"
                                    class="card-img-top"
                                    alt="Image"
                            >

                        <?php endif; ?>


                        <!-- BODY -->

                        <div class="card-body">

                            <h5 class="card-title">

                                Kép #<?= $image['id'] ?>

                            </h5>


                            <p class="mb-2">

                                <strong>Kategória ID:</strong>

                                <?= $image['category_id'] ?>

                            </p>


                            <p class="mb-2">

                                <strong>Állapot:</strong>

                                <?= $image['is_active']
                                    ? 'Aktív'
                                    : 'Inaktív'
                                ?>

                            </p>


                            <p class="mb-2">

                                <strong>Kiemelt:</strong>

                                <?= $image['is_featured']
                                    ? 'Igen'
                                    : 'Nem'
                                ?>

                            </p>


                            <p class="mb-3">

                                <strong>Feltöltve:</strong>

                                <?= $image['created_at'] ?>

                            </p>


                            <!-- LANGUAGES PLACEHOLDER -->

                            <div class="mb-3">

                                <span class="badge bg-secondary">
                                    HU
                                </span>

                                <span class="badge bg-secondary">
                                    EN
                                </span>

                                <span class="badge bg-secondary">
                                    IT
                                </span>

                            </div>


                            <!-- ACTION BUTTONS -->

                            <div class="d-flex gap-2 flex-wrap">

                                <a href="translations.php?id=<?= $image['id'] ?>"
                                   class="btn btn-outline-primary btn-sm">

                                    <i class="bi bi-translate"></i>

                                </a>


                                <a href="edit-image.php?id=<?= $image['id'] ?>"
                                   class="btn btn-outline-secondary btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>


                                <a href="delete-image.php?id=<?= $image['id'] ?>"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirmDelete()">

                                    <i class="bi bi-trash"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>


<?php

require_once 'partials/footer.php';