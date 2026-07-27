<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2)
    . '/app/Core/Bootstrap.php';


use App\Core\Auth;
use App\Models\Category;
use App\Models\GalleryImage;



Auth::requireLogin();



$pageTitle = 'Galéria';



$galleryModel = new GalleryImage();

$categoryModel = new Category();



/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$totalImages = $galleryModel->count();

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
| Category lookup
|--------------------------------------------------------------------------
*/
/*
$categoryNames = [];

foreach ($categories as $category) {

    $categoryNames[$category['id']] = $category['name'];

}
*/
require_once 'partials/header.php';

require_once 'partials/sidebar.php';

?>


<div class="container-fluid py-4">


<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h1 class="mb-1">
Galéria kezelése
</h1>

<p class="text-muted mb-0">
Referenciafotók és projektek kezelése.
</p>

</div>


<div>

<a href="upload.php"
class="btn btn-primary">

<i class="bi bi-cloud-arrow-up-fill"></i>

Új kép feltöltése

</a>

</div>


</div>





<!-- STATISTICS -->

<div class="row mb-5">


<div class="col-lg-6 mb-3">

<div class="card shadow-sm">

<div class="card-body">


<h6 class="text-muted">
Összes referencia kép
</h6>


<h2>
<?= $totalImages ?>
</h2>


</div>

</div>

</div>




<div class="col-lg-6 mb-3">

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





<!-- EMPTY STATE -->


<?php if (empty($images)): ?>


<div class="card shadow-sm">

<div class="card-body text-center py-5">


<i class="bi bi-images fs-1"></i>


<h3 class="mt-3">
Még nincs feltöltött referencia.
</h3>


<p class="text-muted">

Töltsd fel az első projektfotót.

</p>



<a href="upload.php"
class="btn btn-primary">

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





<img
src="../uploads/gallery/<?= htmlspecialchars(
    $image['image'],
    ENT_QUOTES,
    'UTF-8'
) ?>"
class="card-img-top"
alt="<?= htmlspecialchars(
    $image['alt_text'] ?? '',
    ENT_QUOTES,
    'UTF-8'
) ?>"
>






<div class="card-body">



<h5 class="card-title">

<?= htmlspecialchars(
    $image['title'],
    ENT_QUOTES,
    'UTF-8'
) ?>

</h5>




<p class="text-muted">

<?= mb_substr(
    $image['description'],
    0,
    180
) ?>

...

</p>





<p class="mb-2">

<strong>Kategória:</strong>

<?= htmlspecialchars(
    $image['category_name'] ?? 'Nincs kategória',
    ENT_QUOTES,
    'UTF-8'
) ?>

</p>





<p class="mb-2">

<strong>Állapot:</strong>

<?php if ($image['is_active']): ?>

<span class="badge bg-success">
Aktív
</span>

<?php else: ?>

<span class="badge bg-secondary">
Inaktív
</span>

<?php endif; ?>


</p>






<p class="mb-2">

<strong>Sorrend:</strong>

<?= $image['sort_order'] ?>

</p>





<p class="small text-muted">

<?= $image['created_at'] ?>

</p>





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

<span class="badge bg-secondary">
ES
</span>

<span class="badge bg-secondary">
ZH
</span>


</div>





<div class="d-flex gap-2">


<a href="gallery-edit.php?id=<?= $image['id'] ?>"
class="btn btn-outline-secondary btn-sm">

<i class="bi bi-pencil"></i>

</a>




<a href="gallery-delete.php?id=<?= $image['id'] ?>"
class="btn btn-outline-danger btn-sm">

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