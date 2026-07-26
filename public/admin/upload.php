<?php

declare(strict_types=1);


require_once dirname(__DIR__, 2)
    . '/app/Core/Bootstrap.php';


use App\Core\Auth;
use App\Core\Csrf;
use App\Models\Category;
use App\Models\GalleryImage;



Auth::requireLogin();



$pageTitle = 'Új referencia feltöltése';



$categoryModel = new Category();

$galleryModel = new GalleryImage();



$categories = $categoryModel->getAll();



$errors = [];





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
    | Fields
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
            'A cím megadása kötelező.';

    }


    if ($description === '') {

        $errors[] =
            'A leírás megadása kötelező.';

    }





    /*
    |--------------------------------------------------------------------------
    | Image upload
    |--------------------------------------------------------------------------
    */


    if (
        !isset($_FILES['image'])
        ||
        $_FILES['image']['error'] !== UPLOAD_ERR_OK
    ) {

        $errors[] =
            'Kép feltöltése kötelező.';

    }





    if (empty($errors)) {



        $file = $_FILES['image'];



        $allowed = [

            'image/jpeg',
            'image/png',
            'image/webp'

        ];



        $mime = mime_content_type(
            $file['tmp_name']
        );



        if (!in_array($mime, $allowed)) {


            $errors[] =
                'Csak JPG, PNG vagy WEBP kép tölthető fel.';


        }




        if ($file['size'] > 5 * 1024 * 1024) {


            $errors[] =
                'A kép maximum 5 MB lehet.';


        }



    }






    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */


    if (empty($errors)) {


        $extension = pathinfo(
            $file['name'],
            PATHINFO_EXTENSION
        );



        $filename =
            uniqid('gallery_', true)
            . '.'
            . strtolower($extension);



        $uploadPath =
            dirname(__DIR__)
            . '/uploads/gallery/';



        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0755,
                true
            );

        }




        move_uploaded_file(
            $file['tmp_name'],
            $uploadPath . $filename
        );





        $galleryModel->create([

            'category_id' => $categoryId,

            'title' => $title,

            'description' => $description,

            'alt_text' => $altText,

            'image' => $filename,

            'sort_order' => $sortOrder

        ]);





        Csrf::regenerateToken();



        header(
            'Location: gallery.php?success=uploaded'
        );

        exit;


    }



}



require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>


<div class="container-fluid py-4">


<h1>

Új referencia feltöltése

</h1>




<?php if ($errors): ?>


<div class="alert alert-danger">

<ul>

<?php foreach ($errors as $error): ?>

<li>
<?= htmlspecialchars($error) ?>
</li>

<?php endforeach; ?>

</ul>

</div>


<?php endif; ?>





<div class="card">


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


<option value="">
-- választás --
</option>



<?php foreach ($categories as $category): ?>


<option value="<?= $category['id'] ?>">


<?= htmlspecialchars(
    $category['name']
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
maxlength="255"
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
rows="8"
required
></textarea>


<div class="form-text">

Részletes referencia leírás.

</div>


</div>







<div class="mb-3">


<label class="form-label">

Alt szöveg

</label>


<input
type="text"
name="alt_text"
class="form-control"
maxlength="255"
>


</div>







<div class="mb-3">


<label class="form-label">

Kép

</label>


<input
type="file"
name="image"
class="form-control"
accept="image/*"
required
>


</div>







<div class="mb-3">


<label class="form-label">

Sorrend

</label>


<input
type="number"
name="sort_order"
class="form-control"
value="0"
>


</div>







<button
class="btn btn-primary"
type="submit">


Feltöltés


</button>



<a href="gallery.php"
class="btn btn-secondary">

Mégse

</a>



</form>


</div>


</div>


</div>



<?php

require_once 'partials/footer.php';