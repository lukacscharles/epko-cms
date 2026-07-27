<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2)
    . '/app/Core/Bootstrap.php';



use App\Core\Auth;
use App\Core\Csrf;
use App\Models\Category;
use App\Models\GalleryImage;



Auth::requireLogin();



$pageTitle = 'Referencia szerkesztése';



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
| Models
|--------------------------------------------------------------------------
*/

$galleryModel = new GalleryImage();

$categoryModel = new Category();



$image = $galleryModel->getById($id);



if (!$image) {

    die('A referencia nem található.');

}



$categories = $categoryModel->getAll();



$errors = [];





/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    /*
    |--------------------------------------------------------------------------
    | CSRF
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


    $categoryId = (int)(
        $_POST['category_id'] ?? 0
    );


    $title = trim(
        $_POST['title'] ?? ''
    );


    $description = trim(
        $_POST['description'] ?? ''
    );


    $altText = trim(
        $_POST['alt_text'] ?? ''
    );


    $sortOrder = (int)(
        $_POST['sort_order'] ?? 0
    );


    $isActive = isset(
        $_POST['is_active']
    );



    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */


    if ($categoryId <= 0) {

        $errors[] =
            'Válassz kategóriát.';

    }


    if ($title === '') {

        $errors[] =
            'A cím kötelező.';

    }


    if ($description === '') {

        $errors[] =
            'A leírás kötelező.';

    }





    /*
    |--------------------------------------------------------------------------
    | Image handling
    |--------------------------------------------------------------------------
    */


    $filename = $image['image'];



    if (
        isset($_FILES['image'])
        &&
        $_FILES['image']['error'] === UPLOAD_ERR_OK
    ) {



        $tmp = $_FILES['image']['tmp_name'];


        $mime = mime_content_type($tmp);



        $allowed = [

            'image/jpeg',

            'image/png',

            'image/webp'

        ];



        if (
            !in_array(
                $mime,
                $allowed
            )
        ) {

            $errors[] =
                'Csak JPG, PNG vagy WEBP kép engedélyezett.';

        }




        if (
            $_FILES['image']['size']
            >
            5 * 1024 * 1024
        ) {

            $errors[] =
                'A kép maximum 5 MB lehet.';

        }



        if (empty($errors)) {



            $extension =
                pathinfo(
                    $_FILES['image']['name'],
                    PATHINFO_EXTENSION
                );



            $filename =
                uniqid(
                    'gallery_',
                    true
                )
                .
                '.'
                .
                strtolower($extension);



            $uploadPath =
                dirname(__DIR__)
                .
                '/uploads/gallery/';



            move_uploaded_file(
                $tmp,
                $uploadPath . $filename
            );



            /*
             * Régi kép törlése
             */

            if (
                $image['image']
                &&
                file_exists(
                    $uploadPath . $image['image']
                )
            ) {

                unlink(
                    $uploadPath . $image['image']
                );

            }


        }

    }






    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    if (empty($errors)) {


        $galleryModel->update(
            $id,
            [

                'category_id' => $categoryId,

                'title' => $title,

                'description' => $description,

                'alt_text' => $altText,

                'image' => $filename,

                'sort_order' => $sortOrder,

                'is_active' => $isActive

            ]
        );



        Csrf::regenerateToken();



        header(
            'Location: gallery.php?success=updated'
        );

        exit;


    }


}



require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>



<div class="container-fluid py-4">


<h1 class="mb-4">

Referencia szerkesztése

</h1>




<?php if ($errors): ?>


<div class="alert alert-danger">

<ul>

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



<form method="POST"
      enctype="multipart/form-data">



<?= Csrf::inputField() ?>






<div class="mb-3">


<label class="form-label">

Kategória

</label>



<select
name="category_id"
class="form-select"
required>



<?php foreach ($categories as $category): ?>


<option
value="<?= $category['id'] ?>"
<?= $category['id'] == $image['category_id']
    ? 'selected'
    : ''
?>
>


<?= htmlspecialchars(
    $category['name'],
    ENT_QUOTES,
    'UTF-8'
) ?>


</option>



<?php endforeach; ?>


</select>


</div>








<div class="mb-3">


<label class="form-label">

Cím

</label>


<input
type="text"
name="title"
class="form-control"
value="<?= htmlspecialchars(
    $image['title'],
    ENT_QUOTES,
    'UTF-8'
) ?>"
required
>


</div>








<div class="mb-3">


<label class="form-label">

Leírás

</label>


<textarea
name="description"
class="form-control"
rows="10"
required
><?= htmlspecialchars(
    $image['description'],
    ENT_QUOTES,
    'UTF-8'
) ?></textarea>


</div>








<div class="mb-3">


<label class="form-label">

Alt szöveg

</label>


<input
type="text"
name="alt_text"
class="form-control"
value="<?= htmlspecialchars(
    $image['alt_text'] ?? '',
    ENT_QUOTES,
    'UTF-8'
) ?>"
>


</div>








<div class="mb-3">


<label class="form-label">

Jelenlegi kép

</label>


<br>


<img
src="../uploads/gallery/<?= htmlspecialchars(
    $image['image'],
    ENT_QUOTES,
    'UTF-8'
) ?>"
style="max-width:300px"
class="img-thumbnail"
>


</div>








<div class="mb-3">


<label class="form-label">

Új kép feltöltése (opcionális)

</label>


<input
type="file"
name="image"
class="form-control"
accept="image/*"
>


</div>








<div class="mb-3">


<label class="form-label">

Megjelenési sorrend

</label>


<input
type="number"
name="sort_order"
class="form-control"
value="<?= $image['sort_order'] ?>"
>


</div>








<div class="form-check mb-4">


<input
type="checkbox"
name="is_active"
class="form-check-input"
id="active"
<?= $image['is_active']
    ? 'checked'
    : ''
?>
>


<label
class="form-check-label"
for="active">

Aktív referencia

</label>


</div>








<button
type="submit"
class="btn btn-primary">

Mentés

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