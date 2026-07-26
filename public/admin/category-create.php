<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2) . '/app/Core/Bootstrap.php';


use App\Core\Auth;
use App\Core\Csrf;
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

$pageTitle = 'Új kategória';



/*
|--------------------------------------------------------------------------
| Model
|--------------------------------------------------------------------------
*/

$categoryModel = new Category();



/*
|--------------------------------------------------------------------------
| Form handling
|--------------------------------------------------------------------------
*/

$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    /*
    |--------------------------------------------------------------------------
    | CSRF validation
    |--------------------------------------------------------------------------
    */

    if (
        !Csrf::validateToken(
            $_POST['_token'] ?? null
        )
    ) {

        die('Érvénytelen CSRF token.');

    }



    /*
    |--------------------------------------------------------------------------
    | Input
    |--------------------------------------------------------------------------
    */

    $name = trim(
        $_POST['name'] ?? ''
    );



    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($name === '') {

        $errors[] =
            'A kategória neve kötelező.';

    }


    if (mb_strlen($name) > 100) {

        $errors[] =
            'A kategória neve maximum 100 karakter lehet.';

    }



    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    if (empty($errors)) {


        try {


            $categoryModel->create($name);



            header(
                'Location: categories.php?success=created'
            );

            exit;



        } catch (PDOException $e) {


            if (APP_DEBUG) {

                die(
                    $e->getMessage()
                );

            }


            $errors[] =
                'A kategória mentése sikertelen.';

        }


    }


}



/*
|--------------------------------------------------------------------------
| Layout
|--------------------------------------------------------------------------
*/

require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>


<div class="container-fluid py-4">


    <div class="d-flex justify-content-between align-items-center mb-4">


        <div>

            <h1 class="mb-1">
                Új kategória
            </h1>


            <p class="text-muted mb-0">
                Új galéria kategória létrehozása.
            </p>

        </div>



        <div>

            <a href="categories.php"
               class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left"></i>

                Vissza

            </a>

        </div>


    </div>





    <?php if (!empty($errors)): ?>


        <div class="alert alert-danger">


            <ul class="mb-0">


                <?php foreach ($errors as $error): ?>


                    <li>

                        <?= htmlspecialchars(
                            $error,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </li>


                <?php endforeach; ?>


            </ul>


        </div>


    <?php endif; ?>





    <div class="card shadow-sm">


        <div class="card-body">


            <form method="POST">


                <?= Csrf::inputField() ?>



                <div class="mb-3">


                    <label class="form-label">

                        Kategória neve

                    </label>



                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        maxlength="100"
                        required
                        value="<?= htmlspecialchars(
                            $_POST['name'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >


                    <div class="form-text">

                        Például:
                        Referencia munkák,
                        Tetőfedés,
                        Szigetelés

                    </div>


                </div>





                <div class="d-flex gap-2">


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>

                        Mentés

                    </button>




                    <a href="categories.php"
                       class="btn btn-secondary">

                        Mégse

                    </a>


                </div>


            </form>


        </div>


    </div>


</div>



<?php

require_once 'partials/footer.php';