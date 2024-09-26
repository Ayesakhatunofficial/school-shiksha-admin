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
                                    <h4 class="card-title mb-3">Edit Service</h4>

                                    <form class=" row" action="<?= base_url('category/update/' . $category->id) ?>"
                                        method="post" enctype="multipart/form-data">
                                        <div class="form-group col-lg-6">
                                            <label>Service Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Service Name"
                                                name="cat_name" value="<?= $category->service_name ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Service Image <i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <input class="form-control" type="file" name="cat_image">

                                            <div><?= $category->image ?></div>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('image_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Education category <i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="intended_for">
                                                <option value="mp" <?= $category->intended_for == "mp" ? "selected" : "" ?>>Madhyamik Pariksha</option>
                                                <option value="hs" <?= $category->intended_for == "hs" ? "selected" : "" ?>>
                                                    Higher Secondry</option>
                                                <option value="graduate" <?= $category->intended_for == "graduate" ? "selected" : "" ?>>Graduate</option>
                                                <option value="other" <?= $category->intended_for == "other" ? "selected" : "" ?>>Other</option>
                                            </select>
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('intended_for_error'); ?>
                                            </div>
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label>Organisation Course Name<i
                                                    class="mdi mdi-star color-danger"></i></label>
                                            <select multiple class="select2 form-control" data-live-search="true"
                                                id="org_course_id" name='org_course_id[]'>
                                                <?php foreach ($course as $index => $courses) { ?>

                                                    <option value="<?= $courses->id ?>" <?= in_array($courses->id, array_column($course_service, 'org_course_id')) ? "selected" : ""; ?>>
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
                                                <option value="course" <?= ($category->service_type == 'course') ? 'Selected' : '' ?>>Course</option>
                                                <option value="exam" <?= ($category->service_type == 'exam') ? 'Selected' : '' ?>>Exam</option>
                                                <option value="job" <?= ($category->service_type == 'job') ? 'Selected' : '' ?>>Job</option>
                                                <option value="scholarship" <?= ($category->service_type == 'scholarship') ? 'Selected' : '' ?>>Scholarship</option>
                                                <option value="training" <?= ($category->service_type == 'training') ? 'Selected' : '' ?>>Training</option>
                                            </select>
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('service_type_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Status</label>
                                            <select class="form-control" id="exampleSelectStatus" name="status">

                                                <option value="1" <?= ($category->is_active == 1) ? 'Selected' : '' ?>>
                                                    Active</option>
                                                <option value="0" <?= ($category->is_active == 0) ? 'Selected' : '' ?>>
                                                    Inactive</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="terms">Terms & Conditions </label>
                                            <textarea name="terms"
                                                class="form-control"><?= $category->terms_and_conditions ?></textarea>
                                        </div>


                                        <?php
                                        $required_field = isset($category->required_field) ? json_decode($category->required_field) : "";
                                        ?>

                                        <div class="row ml-2">
                                            <div class="form-group col-lg-6">
                                                <label>Location<i class="mdi mdi-star color-danger"></i></label>
                                                <div class="row" style="gap: 6px;margin-left: 5px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="location_option" id="location_yes" value="yes"
                                                            <?= isset($required_field->is_location_required) && $required_field->is_location_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="location_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="location_option" id="location_no" value="no"
                                                            <?= isset($required_field->is_location_required) && $required_field->is_location_required == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="location_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('location_error'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Search<i class="mdi mdi-star color-danger"></i></label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="search_option" id="search_yes" value="yes"
                                                            <?= isset($required_field->is_search_required) && $required_field->is_search_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="search_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="search_option" id="search_no" value="no"
                                                            <?= isset($required_field->is_search_required) && $required_field->is_search_required == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="search_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('search_error'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Aadhar Card<i class="mdi mdi-star color-danger"></i></label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="aadhar_option" id="aadhar_yes" value="yes"
                                                            <?= isset($required_field->is_aadhar_required) && $required_field->is_aadhar_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="aadhar_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="aadhar_option" id="aadhar_no" value="no"
                                                            <?= isset($required_field->is_aadhar_required) && $required_field->is_aadhar_required == 'no' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="aadhar_no">No</label>
                                                    </div>
                                                </div>
                                                <div class="text-danger">
                                                    <?php echo $session->getFlashdata('aadhar_error'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Income Certificate<i
                                                        class="mdi mdi-star color-danger"></i></label>
                                                <div class="row" style="gap: 6px;margin-left: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="income_option" id="income_yes" value="yes"
                                                            <?= isset($required_field->is_income_required) && $required_field->is_income_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="income_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="income_option" id="income_no" value="no"
                                                            <?= isset($required_field->is_income_required) && $required_field->is_income_required == 'no' ? 'checked' : '' ?>>
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
                                                            <?= isset($required_field->is_guardian_details_required) && $required_field->is_guardian_details_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="guardian_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="guardian_option" id="guardian_option" value="no"
                                                            <?= isset($required_field->is_guardian_details_required) && $required_field->is_guardian_details_required == 'no' ? 'checked' : '' ?>>
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
                                                            <?= isset($required_field->is_education_qualification_required) && $required_field->is_education_qualification_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="education_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="education_option" id="education_no" value="no"
                                                            <?= isset($required_field->is_education_qualification_required) && $required_field->is_education_qualification_required == 'no' ? 'checked' : '' ?>>
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
                                                        <input class="form-check-input" type="radio" name="photo_option"
                                                            id="photo_yes" value="yes"
                                                            <?= isset($required_field->is_passport_photo_required) && $required_field->is_passport_photo_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="photo_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="photo_option"
                                                            id="photo_no" value="no"
                                                            <?= isset($required_field->is_passport_photo_required) && $required_field->is_passport_photo_required == 'no' ? 'checked' : '' ?>>
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
                                                        <input class="form-check-input" type="radio" name="terms_option"
                                                            id="terms_yes" value="yes"
                                                            <?= isset($required_field->is_terms_and_conditions_required) && $required_field->is_terms_and_conditions_required == 'yes' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="terms_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="terms_option"
                                                            id="terms_no" value="no"
                                                            <?= isset($required_field->is_terms_and_conditions_required) && $required_field->is_terms_and_conditions_required == 'no' ? 'checked' : '' ?>>
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
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>

</body>

</html>