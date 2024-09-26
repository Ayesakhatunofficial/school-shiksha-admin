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
                                    <h4 class="card-title mb-3">Add Service</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->

                                    <form class=" row" action="<?= base_url('category') ?>" method="post"
                                        enctype="multipart/form-data">
                                        <div class="form-group col-lg-6">
                                            <label>Service Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Service Name"
                                                name="cat_name" value="<?= old('cat_name') ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Service Image <i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <input class="form-control" type="file" accept="image/*" name="cat_image"
                                                value="<?= old('cat_image') ?>">
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('image_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Education Category <i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="intended_for">
                                                <option value="">select</option>
                                                <option value="mp">Madhyamik Pariksha</option>
                                                <option value="hs">Higher Secondry</option>
                                                <option value="graduate">Graduate</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('intended_for_error'); ?>
                                            </div>
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label>Organization Course Name<i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <select multiple class="select2 form-control" data-live-search="true"
                                                id="org_course_id" name='org_course_id[]'>
                                                <?php foreach ($course as $index => $courses) { ?>
                                                    <option value="<?= $courses->id ?>">
                                                        <?= isset($courses->course_name) && isset($courses->organization_name) ? $courses->organization_name . " - " . $courses->course_name : ""; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('course_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="type">Service Type <i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="type" name="service_type">
                                                <option value="">select</option>
                                                <option value="course">Course</option>
                                                <option value="exam">Exam</option>
                                                <option value="job">Job</option>
                                                <option value="scholarship">Scholarship</option>
                                                <option value="training">Training</option>
                                            </select>
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('service_type_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Status</label>
                                            <select class="form-control" id="exampleSelectStatus" name="status">

                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="terms">Terms & Conditions </label>
                                            <textarea name="terms" class="form-control"></textarea>
                                        </div>


                                        <div class="row ml-2">
                                            <div class="form-group col-lg-6">
                                                <label>Location<i class="mdi mdi-star color-danger"></i> </label>
                                                <div class="row" style="gap: 6px;margin-left: 5px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="location_option" id="location_yes" value="yes"
                                                            <?= old('location_option') !== null && old('location_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="location_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="location_option" id="location_no" value="no"
                                                            <?= old('location_option') !== null && old('location_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="location_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('location_error'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Search<i class="mdi mdi-star color-danger"></i> </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="search_option" id="search_yes" value="yes"
                                                            <?= old('search_option') !== null && old('search_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="search_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="search_option" id="search_no" value="no"
                                                            <?= old('search_option') !== null && old('search_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="search_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('search_error'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Aadhar Card<i class="mdi mdi-star color-danger"></i> </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="aadhar_option" id="aadhar_yes" value="yes"
                                                            <?= old('aadhar_option') !== null && old('aadhar_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="aadhar_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="aadhar_option" id="aadhar_no" value="no"
                                                            <?= old('aadhar_option') !== null && old('aadhar_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="aadhar_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('aadhar_error'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Income Certificate<i class="mdi mdi-star color-danger"></i>
                                                </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="income_option" id="income_yes" value="yes"
                                                            <?= old('income_option') !== null && old('income_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="income_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="income_option" id="income_no" value="no"
                                                            <?= old('income_option') !== null && old('income_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="income_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('income_error'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Guardian Details <i class="mdi mdi-star color-danger"></i>
                                                </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="guardian_option" id="guardian_yes" value="yes"
                                                            <?= old('guardian_option') !== null && old('guardian_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="guardian_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="guardian_option" id="guardian_option" value="no"
                                                            <?= old('guardian_option') !== null && old('guardian_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="guardian_option">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('guardian_error'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Education Qualification<i class="mdi mdi-star color-danger"></i>
                                                </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="education_option" id="education_yes" value="yes"
                                                            <?= old('education_option') !== null && old('education_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="education_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="education_option" id="education_no" value="no"
                                                            <?= old('education_option') !== null && old('education_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="education_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('education_error'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Passport Photo<i class="mdi mdi-star color-danger"></i>
                                                </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="photo_option" id="photo_yes" value="yes"
                                                            <?= old('photo_option') !== null && old('photo_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="photo_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="photo_option" id="photo_no" value="no"
                                                            <?= old('photo_option') !== null && old('photo_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="photo_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('photo_error'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Terms & Conditions<i class="mdi mdi-star color-danger"></i>
                                                </label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="terms_option" id="terms_yes" value="yes"
                                                            <?= old('terms_option') !== null && old('terms_option') == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="terms_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="terms_option" id="terms_no" value="no"
                                                            <?= old('terms_option') !== null && old('terms_option') == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="terms_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('terms_error'); ?>
                                                </div>
                                            </div>

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

    <script>
        $('.select2').select2({
            placeholder: "Select Organization Courses", // Placeholder text
            allowClear: true // Allow the user to clear the selection
        });
    </script>

</body>

</html>