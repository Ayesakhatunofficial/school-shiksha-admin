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
                                    <h4 class="card-title mb-3">Add Student</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->


                                    <form class=" row" action="<?= base_url('student/add') ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-lg-6">
                                            <label>Full Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Full Name" name="name" value="<?= old('name') ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Email <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="email" value="<?= old('email') ?>" class="form-control" placeholder="Student Email" name="email" autocomplete="off">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('email_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                                            <input type="number" class="form-control" placeholder="Student Mobile No." name="mobile" value="<?= old('mobile') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('mobile_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Whatsapp No. <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="number" class="form-control" placeholder="Enter Whatsapp No." name="whatsapp_number" value="<?= old('whatsapp_number') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('whatsapp_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Guardian Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Guardian Name" name="father_name" value="<?= old('father_name') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('father_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Guardian Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                                            <input type="number" class="form-control" placeholder="Guardian Mobile No." name="guardian_mobile" value="<?= old('guardian_mobile') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('guardian_mobile_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Guardian Occupation <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Guardian Occupation" name="guardian_occupation" value="<?= old('guardian_occupation') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('guardian_occupation_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Date of Birth<i class="mdi mdi-star color-danger"></i></label>
                                            <input type="date" class="form-control" placeholder=" " name="dob" value="<?= old('dob') ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('dob_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Gender <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="gender">
                                                <option value=""> -- Select --</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Others</option>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('gender_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> School/College Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="School/College Name" name="institute_name" value="<?= old('institute_name') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('institute_name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Class Name <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="class_id">
                                                <option value=""> -- Select --</option>
                                                <?php foreach ($class as $classdata) : ?>
                                                    <option value="<?= $classdata['id'] ?>"><?= $classdata['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('class_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Stream Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Stream Name" name="stream_name" value="<?= old('stream_name') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('stream_name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Religion <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Student Religion" name="religion" value="<?= old('religion') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('religion_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Address <i class="mdi mdi-star color-danger"></i></label>

                                            <textarea name="address" class="form-control" placeholder="Enter Address"><?= old('address') ?></textarea>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('address_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Pin Code <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Enter Pin Code" name="pincode" value="<?= old('pincode') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('pincode_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Police Station <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Enter Police Station" name="police_station" value="<?= old('police_station') ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('police_station_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">State <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="state_id" name="state_id">
                                                <option value="">--Select--</option>
                                                <?php foreach ($states as $row) { ?>
                                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('state_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">District <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" name="district_id" id="district_id">
                                                <option value="">--Select--</option>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('district_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Password <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="password" class="form-control" placeholder="Enter Password" name="password" value="<?= old('password') ?>" autocomplete="new-password">
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('password_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Plans<i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" name="plan_id">
                                                <option value="">--Select--</option>

                                                <?php foreach ($plans as $plan) { ?>
                                                    <option value="<?= $plan['id'] ?>"><?= $plan['plan_name'] ?></option>
                                                <?php } ?>

                                            </select>

                                            <div class="text-danger"><?php echo $session->getFlashdata('plan_error'); ?>
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

</body>

</html>
<script>
    $(document).ready(function() {
        // Get today's date in YYYY-MM-DD format
        var today = new Date().toISOString().split('T')[0];
        // Set max attribute of date input to today's date
        $('input[name="dob"]').attr('max', today);
        // When the value of the select dropdown changes
        $('#state_id').change(function() {
            var stateId = $(this).val(); // Get the selected state_id
            $('#district_id').html("");

            // Make AJAX call to fetch data based on selected state_id
            $.ajax({
                url: '<?= base_url('/organization/district/') ?>' + stateId,
                type: 'GET', // Use GET method since you are fetching data
                success: function(response) {
                    // Assuming response is HTML options, update the select dropdown
                    $('#district_id').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error); // Log the error (for debugging)
                }
            });
        });
    });
</script>