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
                                    <h4 class="card-title mb-3">Edit Student</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->


                                    <form class="row" action="<?= base_url('student/edit/' . $student->id) ?>" method="POST" enctype="multipart/form-data">

                                        <input type="hidden" value="<?= $student->user_id ?>" name="user_id">
                                        <div class="form-group col-lg-6">
                                            <label>Student Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Student Name" name="name" value="<?= $student->name ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Email <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="email" class="form-control" placeholder="Student Email" name="email" value="<?= $student->email ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('email_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Mobile <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Student Mobile" name="mobile" value="<?= $student->mobile ?>" readonly>

                                            <div class="text-danger"><?php echo $session->getFlashdata('mobile_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Whatsapp Number <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Enter Whatsapp Number" name="whatsapp_number" value="<?= $student->whatsapp_number ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('whatsapp_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Guardian Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Guardian Name" name="father_name" value="<?= $student->father_name ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('father_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Guardian Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                                            <input type="number" class="form-control" placeholder="Guardian Mobile No." name="guardian_mobile" value="<?= $student->guardian_mobile ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('guardian_mobile_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Guardian Occupation <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Guardian Occupation" name="guardian_occupation" value="<?= $student->guardian_occupation ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('guardian_occupation_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Date of Birth<i class="mdi mdi-star color-danger"></i></label>
                                            <input type="date" class="form-control" placeholder=" " name="dob" value="<?= $student->date_of_birth ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('dob_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Gender <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="gender">
                                                <option value=""> -- Select --</option>
                                                <option value="male" <?= ($student->gender == 'male') ? 'Selected' : '' ?>>Male</option>
                                                <option value="female" <?= ($student->gender == 'female') ? 'Selected' : '' ?>>Female</option>
                                                <option value="other" <?= ($student->gender == 'other') ? 'Selected' : '' ?>>Others</option>
                                            </select>

                                            <div class="text-danger"><?php echo $session->getFlashdata('gender_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> School/College Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="School/College Name" name="institute_name" value="<?= $student->institute_name ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('institute_name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Class Name <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="class_id">
                                                <option value=""> -- Select --</option>
                                                <?php foreach ($class as $classdata) : ?>
                                                    <option value="<?= $classdata['id'] ?>" <?= $classdata['id'] == $student->class_id ? 'Selected' : '' ?>><?= $classdata['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('class_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label> Stream Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Stream Name" name="stream_name" value="<?= $student->stream_name ?>">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('stream_name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Religion <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Student Religion" name="religion" value="<?= $student->religion ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('religion_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Address <i class="mdi mdi-star color-danger"></i></label>

                                            <textarea name="address" class="form-control" placeholder="Enter Address"><?= $student->address ?></textarea>

                                            <div class="text-danger"><?php echo $session->getFlashdata('address_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Pin Code <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Enter Pin Code" name="pincode" value="<?= $student->pincode ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('pincode_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Police Station <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Enter Police Station" name="police_station" value="<?= $student->police_station ?>">

                                            <div class="text-danger"><?php echo $session->getFlashdata('police_station_error'); ?></div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">State <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="state_id" name="state_id">
                                                <option value="">--Select--</option>
                                                <?php foreach ($states as $row) { ?>
                                                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $state['state_id']) ? 'Selected' : '' ?>><?= $row['name'] ?></option>
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

                                                <?php foreach ($districts as $district) { ?>
                                                    <option value="<?= $district['id'] ?>" <?= ($student->district_id == $district['id']) ? 'Selected' : '' ?>><?= $district['name'] ?></option>
                                                <?php } ?>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('district_error'); ?>
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
        $(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            $('input[name="dob"]').attr('max', today);

            $('#state_id').change(function() {
                var stateId = $(this).val();
                $('#district_id').html("");

                $.ajax({
                    url: '<?= base_url('/organization/district/') ?>' + stateId,
                    type: 'GET',
                    success: function(response) {
                        $('#district_id').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

</body>



</html>