<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2)
    . '/app/Core/Bootstrap.php';



use App\Core\Auth;
use App\Core\Csrf;
use App\Models\GalleryImage;



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::requireLogin();



/*
|--------------------------------------------------------------------------
| ID
|--------------------------------------------------------------------------
*/

$id = (int)(
    $_GET['id'] ?? 0
);



if ($id <= 0) {

    die('Érvénytelen azonosító.');

}




/*
|--------------------------------------------------------------------------
| Model
|--------------------------------------------------------------------------
*/

$galleryModel = new GalleryImage();



$image = $galleryModel->getById($id);



if (!$image) {

    die('A kép nem található.');

}




/*
|--------------------------------------------------------------------------
| Delete request
|--------------------------------------------------------------------------
*/

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
    | Delete physical file
    |--------------------------------------------------------------------------
    */

    $filePath =
        dirname(__DIR__)
        .
        '/uploads/gallery/'
        .
        $image['image'];



    if (
        !empty($image['image'])
        &&
        file_exists($filePath)
    ) {

        unlink($filePath);

    }





    /*
    |--------------------------------------------------------------------------
    | Delete database record
    |--------------------------------------------------------------------------
    */

    $galleryModel->delete($id);



    Csrf::regenerateToken();



    header(
        'Location: gallery.php?success=deleted'
    );

    exit;

}





require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>


<div class="container-fluid py-4">


<div class="card shadow-sm">


<div class="card-body text-center">



<h2 class="mb-4">

Referencia törlése

</h2>




<img
src="../uploads/gallery/<?= htmlspecialchars(
    $image['image'],
    ENT_QUOTES,
    'UTF-8'
) ?>"
class="img-thumbnail mb-4"
style="max-width:300px"
>




<h5>

<?= htmlspecialchars(
    $image['title'],
    ENT_QUOTES,
    'UTF-8'
) ?>

</h5>




<p class="text-muted">

Biztosan törölni szeretnéd ezt a referencia elemet?

</p>





<form method="POST">


<?= Csrf::inputField() ?>



<button
type="submit"
class="btn btn-danger">

<i class="bi bi-trash"></i>

Igen, törlés

</button>




<a href="gallery.php"
class="btn btn-secondary">

Mégsem

</a>



</form>



</div>


</div>


</div>



<?php

require_once 'partials/footer.php';