<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2)
    . '/app/Core/Bootstrap.php';


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
| Category ID
|--------------------------------------------------------------------------
*/

$id = (int)(
    $_GET['id'] ?? 0
);



if ($id <= 0) {

    die(
        'Érvénytelen kategória azonosító.'
    );

}





/*
|--------------------------------------------------------------------------
| Model
|--------------------------------------------------------------------------
*/

$categoryModel = new Category();



$category = $categoryModel->find($id);



if (!$category) {

    die(
        'A kategória nem található.'
    );

}






/*
|--------------------------------------------------------------------------
| Delete action
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    if (
        !Csrf::validateToken(
            $_POST['_token'] ?? null
        )
    ) {

        die(
            'Érvénytelen CSRF token.'
        );

    }



    try {


        $categoryModel->delete($id);



        Csrf::regenerateToken();



        header(
            'Location: categories.php?success=deleted'
        );

        exit;



    } catch (PDOException $e) {


        if (APP_DEBUG) {

            die(
                $e->getMessage()
            );

        }


        die(
            'A kategória törlése sikertelen.'
        );


    }


}





/*
|--------------------------------------------------------------------------
| Layout
|--------------------------------------------------------------------------
*/

$pageTitle = 'Kategória törlése';



require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>


<div class="container-fluid py-4">



<div class="card shadow-sm">


<div class="card-body">



<h1 class="mb-3">

Kategória törlése

</h1>




<div class="alert alert-danger">


<strong>
Figyelem!
</strong>


<br>


A kategória törlésével a hozzá tartozó
galériaelemek is törlődhetnek.


</div>






<p>

Biztosan törölni szeretnéd?


</p>



<p>

<strong>

<?= htmlspecialchars(
    $category['name'],
    ENT_QUOTES,
    'UTF-8'
) ?>

</strong>


</p>






<form method="POST">


<?= Csrf::inputField() ?>





<button
type="submit"
class="btn btn-danger">


<i class="bi bi-trash"></i>


Törlés


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