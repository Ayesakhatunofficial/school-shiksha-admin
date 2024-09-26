<!DOCTYPE html>
<html lang="en">

<?= view('includes/head.php') ?>

<body>

    <div class="container-scroller">

        <?= view('includes/header.php') ?>

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->

            <?= view('includes/sidebar.php') ?>

            <!-- partial -->

            <div class="main-panel">

                <?= view('includes/msg.php') ?>

                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-home"></i>
                            </span> Dashboard
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="row">

                        <?php
                        $user = getUserData();
                        $role = getRole($user->role_id);
                        if ($role == ROLE_AFFILATE_AGENT) {

                            if (!empty($banners)) {
                        ?>
                                <div class="col-12">

                                    <div id="bannerCarousel" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#bannerCarousel" data-slide-to="1"></li>
                                            <li data-target="#bannerCarousel" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <?php
                                            foreach ($banners as $key =>  $banner) { ?>
                                                <div class="carousel-item <?= ($key == 0) ? 'active' : '' ?>">
                                                    <img src="<?= $banner->banner ?>" class="d-block w-100" alt="...">
                                                </div>
                                            <?php
                                            } ?>

                                        </div>
                                    </div>

                                </div>
                        <?php }
                        } ?>


                        <div class="row col-md-12 mb-4 text-center">

                            <div class="form-group col-md-4">
                                <label for="" class="form-label">From Date <i class="mdi mdi-star color-danger"></i></label>
                                <input type="date" class="form-control" name="from_date" id="from_date" value="<?= $from_date ?>">
                                <span id="from_date_error" class="text-danger"></span>

                            </div>

                            <div class="form-group col-md-4">
                                <label for="" class="form-label">To Date <i class="mdi mdi-star color-danger"></i></label>
                                <input type="date" class="form-control" name="to_date" id="to_date" value="<?= $to_date ?>">
                                <span id="to_date_error" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <button class="btn btn-primary btn-sm mt-3" id="submit_btn">Submit</button>
                                <!-- <a href="" class="btn btn-primary btn-sm">Submit</a> -->
                            </div>
                        </div>

                        <?php
                        if ($role == ROLE_SUPER_ADMIN || $role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR) { ?>

                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-danger card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Affiliation Agent <i class="mdi mdi-svg mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5"><?= isset($agent->total_agent) ? $agent->total_agent : '0'; ?></h2>
                                        <!-- <h6 class="card-text">Increased by 60%</h6> -->
                                    </div>
                                </div>
                            </div>

                        <?php }
                        if ($role == ROLE_SUPER_ADMIN || $role == ROLE_MASTER_DISTRIBUTOR) { ?>

                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-info card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Distributor Agent <i class="mdi mdi mdi-truck-delivery mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5"><?= isset($distributor->total_distributor) ? $distributor->total_distributor : '0'; ?></h2>
                                        <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                                    </div>
                                </div>
                            </div>

                        <?php }
                        if ($role == ROLE_SUPER_ADMIN) { ?>
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-success card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Master Distributor Agent <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5"><?= isset($master_distributor->total_master_distributor) ? $master_distributor->total_master_distributor : '0'; ?></h2>
                                        <!-- <h6 class="card-text">Increased by 5%</h6> -->
                                    </div>
                                </div>
                            </div>

                        <?php }
                        if ($role == ROLE_SUPER_ADMIN || $role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR) { ?>

                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-blue card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Active Agent<i class="mdi mdi-diamond mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5"><?= isset($active_agent->total_active_agent) ? $active_agent->total_active_agent : '0'; ?></h2>
                                        <!-- <h6 class="card-text">Increased by 5%</h6> -->
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-dark card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Active Student<i class="mdi mdi-diamond mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?= isset($active_student->total_active_student) ? $active_student->total_active_student : '0'; ?></h2>
                                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-primary card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Total Students <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?= isset($student->total_student) ? $student->total_student : '0'; ?></h2>
                                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
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



    <script>
        document.getElementById("submit_btn").addEventListener("click", function() {

            var fromDate = document.getElementById("from_date").value;
            var toDate = document.getElementById("to_date").value;

            var messageFromDate = document.getElementById("from_date_error");
            var messageToDate = document.getElementById("to_date_error");

            if (fromDate === '') {
                messageFromDate.textContent = "Please enter from date.";
            }
            if (toDate === '') {
                messageToDate.textContent = "Please enter to date.";
            }

            if (fromDate && toDate) {

                var url = "<?= base_url('dashboard') ?>?" + "from_date=" + encodeURIComponent(fromDate) + "&to_date=" + encodeURIComponent(toDate);

                window.location.href = url;
            }
        });
    </script>
</body>

</html>