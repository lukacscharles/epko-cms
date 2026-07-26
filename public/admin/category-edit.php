<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2)
    . '/app/Core/Bootstrap.php';


use App\Core\Auth;
use App\Core\Csrf;
use App\Models\Category;



Auth::requireLogin();



$pageTitle = 'Kategória szerkesztése';



$categoryModel = new Category();



$errors = [];





/*
|--------------------------------------------------------------------------
| Category ID
|--------------------------------------------------------------------------
*/


$id = (int)(
    $_GET['id'] ?? 0
);



if ($id <= 0) {

    die('Érvénytelen kategória azonosító.');

}



$category = $categoryModel->find($id);



if (!$category) {

    die('A kategória nem található.');

}






/*
|--------------------------------------------------------------------------
| Form submit
|--------------------------------------------------------------------------
*/


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (
        !Csrf::validateToken(
            $_POST['_token'] ?? null
        )
    ) {

        die('Érvénytelen CSRF token.');

    }





    $name = trim(
        $_POST['name'] ?? ''
    );



    $sortOrder = (int)(
        $_POST['sort_order'] ?? 0
    );



    $isActive = isset(
        $_POST['is_active']
    ) ? 1 : 0;






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
    | Update
    |--------------------------------------------------------------------------
    */


    if (empty($errors)) {


        try {


            $categoryModel->update(
                $id,
                $name,
                $sortOrder,
                $isActive
            );



            Csrf::regenerateToken();



            header(
                'Location: categories.php?success=updated'
            );

            exit;



        } catch (PDOException $e) {


            if (APP_DEBUG) {

                die(
                    $e->getMessage()
                );

            }


            $errors[] =
                'A kategória módosítása sikertelen.';


        }


    }


}






require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>



<div class="container-fluid py-4">



<div class="d-flex justify-content-between align-items-center mb-4">


<div>

<h1>

Kategória szerkesztése

</h1>


<p class="text-muted">

<?= htmlspecialchars(
    $category['name'],
    ENT_QUOTES,
    'UTF-8'
) ?>

</p>


</div>




<a href="categories.php"
   class="btn btn-secondary">


<i class="bi bi-arrow-left"></i>

Vissza


</a>



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
    $_POST['name']
    ?? $category['name'],
    ENT_QUOTES,
    'UTF-8'
) ?>"
>



</div>







<div class="mb-3">


<label class="form-label">

Slug

</label>



<input
type="text"
class="form-control"
readonly
value="<?= htmlspecialchars(
    $category['slug'],
    ENT_QUOTES,
    'UTF-8'
) ?>"
>



<div class="form-text">

A slug automatikusan generált,
SEO azonosító.

</div>


</div>








<input
    type="number"
    name="sort_order"
    class="form-control"
    value="<?= htmlspecialchars(
        (string)(
            $_POST['sort_order']
            ??
            $category['sort_order']
            ??
            0
        ),
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
>







<div class="form-check mb-4">


<input
type="checkbox"
name="is_active"
id="is_active"
class="form-check-input"

<?= (
    isset($_POST['is_active'])
    ||
    (!isset($_POST['is_active'])
    && $category['is_active'])
)
?
'checked'
:
''
?>

>


<label
for="is_active"
class="form-check-label">


Aktív kategória


</label>


</div>







<button
type="submit"
class="btn btn-primary">


<i class="bi bi-save"></i>

Mentés


</button>




<a href="categories.php"
class="btn btn-secondary">


Mégse


</a>





</form>


</div>


</div>


</div>




<?php

require_once 'partials/footer.php';