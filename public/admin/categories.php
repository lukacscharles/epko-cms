<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2) . '/app/Core/Bootstrap.php';


use App\Core\Auth;
use App\Models\Category;


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

$pageTitle = 'Kategóriák';



/*
|--------------------------------------------------------------------------
| Model
|--------------------------------------------------------------------------
*/

$categoryModel = new Category();



/*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
*/

$categories = $categoryModel->getAll();

$totalCategories = $categoryModel->count();



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
                Kategóriák
            </h1>


            <p class="text-muted mb-0">
                A galéria kategóriáinak kezelése.
            </p>

        </div>


        <div>

            <a href="category-create.php"
               class="btn btn-primary">

                <i class="bi bi-folder-plus"></i>

                Új kategória

            </a>

        </div>


    </div>





    <!-- STATISTICS -->


    <div class="row mb-4">


        <div class="col-lg-4">


            <div class="card shadow-sm">


                <div class="card-body">


                    <h6 class="text-muted">
                        Összes kategória
                    </h6>


                    <h2>
                        <?= $totalCategories ?>
                    </h2>


                </div>


            </div>


        </div>


    </div>





    <!-- CATEGORY LIST -->


    <div class="card shadow-sm">


        <div class="card-header">

            Kategória lista

        </div>



        <div class="card-body">


            <?php if (empty($categories)): ?>


                <div class="text-center py-5">


                    <i class="bi bi-folder-x fs-1"></i>


                    <h3 class="mt-3">

                        Még nincs kategória.

                    </h3>


                    <p class="text-muted">

                        Hozd létre az első galéria kategóriát.

                    </p>


                    <a href="category-create.php"
                       class="btn btn-primary">

                        Első kategória létrehozása

                    </a>


                </div>



            <?php else: ?>



                <div class="table-responsive">


                    <table class="table table-hover align-middle">


                        <thead>


                        <tr>

                            <th>
                                ID
                            </th>


                            <th>
                                Név
                            </th>


                            <th>
                                Létrehozva
                            </th>


                            <th class="text-end">
                                Műveletek
                            </th>


                        </tr>


                        </thead>



                        <tbody>



                        <?php foreach ($categories as $category): ?>


                            <tr>


                                <td>

                                    <?= $category['id'] ?>

                                </td>



                                <td>


                                    <strong>

                                        <?= htmlspecialchars(
                                            $category['name']
                                        ) ?>

                                    </strong>


                                </td>



                                <td>

                                    <?= htmlspecialchars(
                                        $category['created_at']
                                    ) ?>


                                </td>




                                <td class="text-end">


                                    <a href="category-edit.php?id=<?= $category['id'] ?>"
                                       class="btn btn-sm btn-outline-secondary">


                                        <i class="bi bi-pencil"></i>


                                    </a>




                                    <a href="category-delete.php?id=<?= $category['id'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirmDelete();">


                                        <i class="bi bi-trash"></i>


                                    </a>



                                </td>



                            </tr>


                        <?php endforeach; ?>



                        </tbody>


                    </table>


                </div>



            <?php endif; ?>


        </div>


    </div>



</div>



<?php

require_once 'partials/footer.php';