<?php

declare(strict_types=1);

?>


<section id="references"
         class="py-5">


    <div class="container">


        <!--
        |--------------------------------------------------------------------------
        | Section title
        |--------------------------------------------------------------------------
        -->

        <div class="text-center mb-5">

            <h2 class="display-5 fw-bold">

                Referenciáink

            </h2>


            <p class="lead">

                Több évtizedes szakmai tapasztalatunkat
                számos középület, műemléki felújítás és
                egyedi természetes kőből készült kivitelezés
                fémjelzi.

            </p>

        </div>



        <!--
        |--------------------------------------------------------------------------
        | Gallery items
        |--------------------------------------------------------------------------
        -->

        <div class="row g-4">


            <?php foreach ($galleryImages as $image): ?>


                <div class="col-lg-4 col-md-6">


                    <div class="card shadow-sm border-0 h-100">


                        <!-- IMAGE -->


                        <a href="<?= APP_URL ?>/uploads/gallery/<?= htmlspecialchars(
                                    $image['image'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"  target="_blank">
                                 <img
                                src="<?= APP_URL ?>/uploads/gallery/<?= htmlspecialchars(
                                    $image['image'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars(
                                    $image['alt_text'] ?? $image['title'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                        ></a>




                        <!-- BODY -->


                        <div class="card-body d-flex flex-column">


                            <!-- CATEGORY -->


                            <?php if (!empty($image['category_name'])): ?>

                                <span class="badge bg-secondary mb-3">

                                    <?= htmlspecialchars(
                                        $image['category_name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </span>

                            <?php endif; ?>



                            <!-- TITLE -->


                            <h4 class="card-title mb-3">

                                <?= htmlspecialchars(
                                    $image['title'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h4>



                            <!-- DESCRIPTION -->


                            <p class="card-text flex-grow-1">

                                <?= nl2br(
                                    htmlspecialchars(
                                        $image['description'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                ) ?>

                            </p>






                        </div>


                    </div>


                </div>





                <!--
                |--------------------------------------------------------------------------
                | Bootstrap Modal
                |--------------------------------------------------------------------------
                -->

                <div class="modal fade"
                     id="imageModal<?= $image['id'] ?>"
                     tabindex="-1">


                    <div class="modal-dialog modal-xl modal-dialog-centered">


                        <div class="modal-content">


                            <div class="modal-header">


                                <h5 class="modal-title">

                                    <?= htmlspecialchars(
                                        $image['title'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </h5>


                                <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">

                                </button>


                            </div>



                            <div class="modal-body">


                                <img
                                        src="<?= APP_URL ?>/uploads/gallery/<?= htmlspecialchars(
                                            $image['image'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        class="img-fluid rounded mb-4"
                                        alt="">



                                <p>

                                    <?= nl2br(
                                        htmlspecialchars(
                                            $image['description'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ) ?>

                                </p>


                            </div>


                        </div>


                    </div>


                </div>


            <?php endforeach; ?>


        </div>


    </div>


</section>