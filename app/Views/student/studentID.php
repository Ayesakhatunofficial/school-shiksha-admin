<!DOCTYPE html>
<html lang="en">
<?php $session = session(); ?>

<?= view('includes/head.php') ?>

<body>

    <div class="container-scroller">

        <?= view('includes/header.php') ?>

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->

            <?= view('includes/sidebar.php') ?>

            <!-- partial -->

            <div class="main-panel">


                <div class="content-wrapper">
                    <?= view('includes/msg.php') ?>
                    <div class="card">
                        <div class="card-body container common_list_table">
                            <div class="row">
                                <div class="container">

                                    <h4 class="card-title text-center text-primary mb-3">Student ID Card</h4>

                                    <div class="row col-lg-12">
                                        <div class="col-lg-6">
                                            <img src="<?= isset($student_id_card['id_card_front']) ? $student_id_card['id_card_front'] : '#' ?>" alt="" height="230" width="350">
                                        </div>
                                        <div class="col-lg-6">
                                            <img src="<?= isset($student_id_card['id_card_back']) ? $student_id_card['id_card_back'] : '#' ?>" alt="" height="230" width="350">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <?= view('includes/footer.php') ?>

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <?= view('includes/script.php') ?>



</body>

</html>