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
                                    <h4 class="card-title mb-3">Add Organization</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->


                                    <form class=" row needs-validation" action="<?= base_url('organization') ?>" method="post" enctype="multipart/form-data" id="quickForm" novalidate>
                                        <div class="form-group col-lg-6">
                                            <label>Organization Name <i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Organization Name" name="org_name">

                                            <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Organization Logo <i class="mdi mdi-star color-danger"></i></label>
                                            <input class="form-control" type="file" name="org_image">

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('image_error'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                                            <input class="form-control" type="number" placeholder="Mobile No." name="mobile">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="exampleInputName1">Whatsapp No. <i class="mdi mdi-star color-danger"></i></label>
                                            <input class="form-control" type="number" placeholder="Whatsapp No." name="whatsapp_number">
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
                                            <select class="form-control" id="district_id" name="district_id">
                                                <option value="">--Select--</option>

                                            </select>
                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('district_error'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Block <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="block_id" name="block_id">
                                                <option value="">--Select--</option>
                                            </select>

                                            <div class="text-danger">
                                                <?php echo $session->getFlashdata('block_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Type <i class="mdi mdi-star color-danger"></i></label>
                                            <select class="form-control" id="exampleSelectStatus" name="type">
                                                <option value="">--Select--</option>
                                                <option value="college">College</option>
                                                <option value="others">Others</option>
                                            </select>

                                            <div class="text-danger"><?php echo $session->getFlashdata('type_error'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="exampleSelectStatus">Status</label>
                                            <select class="form-control" id="exampleSelectStatus" name="status">

                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
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
<script>
    $(document).ready(function() {
        $('#quickForm').validate({
            rules: {
                org_name: {
                    required: true
                },
                org_image: {
                    required: true
                },
                state_id: {
                    required: true
                },
                district_id: {
                    required: true
                },
                block_id: {
                    required: true
                },
                type: {
                    required: true
                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                whatsapp_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages: {
                org_name: {
                    required: "Please enter organization name"
                },
                org_image: {
                    required: "Please select organization logo"
                },
                state_id: {
                    required: "Please select state"
                },
                district_id: {
                    required: "Please select district"
                },
                block_id: {
                    required: "Please select block"
                },
                type: {
                    required: "Please select type"
                },
                mobile: {
                    required: "Please enter mobile number",
                    digits: "Please enter a valid mobile number",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must not exceed 10 digits"
                },
                whatsapp_number: {
                    required: "Please enter Whatsapp number",
                    digits: "Please enter a valid Whatsapp number",
                    minlength: "Whatsapp number must be 10 digits",
                    maxlength: "Whatsapp number must not exceed 10 digits"
                }
            },
            errorClass: "text-danger",
            errorElement: "span",
            submitHandler: function(form) {
                // Optionally, perform additional client-side validation here
                console.log("Form submitted successfully!"); // Check if this message appears in the console
                form.submit(); // Submit the form if all validations pass
            }
        });

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

        $('#district_id').change(function() {
            var district_id = $(this).val(); // Get the selected district_id
            $('#block_id').html("");

            // Make AJAX call to fetch data based on selected district_id
            $.ajax({
                url: '<?= base_url('/organization/blocks/') ?>' + district_id,
                type: 'GET', // Use GET method since you are fetching data
                success: function(response) {
                    console.log(response) // Assuming response is HTML options, update the select dropdown
                    $('#block_id').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error); // Log the error (for debugging)
                }
            });
        });
    });
</script>