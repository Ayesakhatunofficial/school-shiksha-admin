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

                <?= view('includes/msg.php') ?>

                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Edit Course</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->


                                    <form class=" row" action="<?= base_url('course/update/' . $course->id) ?>"
                                        method="post" enctype="multipart/form-data">
                                        <div class="form-group col-lg-6">
                                            <label>Course Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Course Name"
                                                name="course_name" value="<?= $course->name ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Course Type</label>
                                            <select class="form-control" name="course_type">
                                                <option value="">--Select--</option>
                                                <option value="online_course" <?= ($course->course_type == 'online_course') ? 'Selected' : '' ?>>Online Course</option>
                                                <option value="computer_course"
                                                    <?= ($course->course_type == 'computer_course') ? 'Selected' : '' ?>>
                                                    Computer Course</option>
                                                <option value="others" <?= ($course->course_type == 'others') ? 'Selected' : '' ?>>Others</option>
                                            </select>

                                            <div class="text-danger"><?php echo $session->getFlashdata('type_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Course Details <i class="mdi mdi-star color-danger"></i></label>

                                            <textarea name="course_details" class="ckeditor form-control"
                                                placeholder="Course Details"><?= $course->course_details ?></textarea>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('details_error'); ?></div>
                                        </div>



                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Status</label>
                                            <select class="form-control" id="exampleSelectStatus" name="status">

                                                <option value="1" <?= ($course->is_active == 1) ? 'Selected' : '' ?>>Active
                                                </option>
                                                <option value="0" <?= ($course->is_active == 0) ? 'Selected' : '' ?>>
                                                    Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                            <a class="btn btn-light" href="<?= base_url('dashboard') ?>">Cancel</a>
                                        </div>

                                    </form>
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