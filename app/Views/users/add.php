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
                <div class="content-wrapper">
                    <?= view('includes/msg.php') ?>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Add User</h4>
                                    <?php echo form_open(base_url('addusers'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>

                                    <div class="form-group col-lg-6">
                                        <label>User Roles <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="role_id" id="role_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($roles as $row) { ?>
                                                <option value="<?= $row->id ?>">
                                                    <?= ucwords(str_replace('_', ' ', $row->role_name)) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Name<i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="text" class="form-control" id="name" placeholder="Enter a name" name="name">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Email<i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="email" class="form-control" id="email" placeholder="Enter an email" name="email" autocomplete="off">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="number" class="form-control" id="mobile" placeholder="Enter a mobile no." name="mobile">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label>Password<i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="password" class="form-control" id="password" placeholder="Enter a password" name="password" autocomplete="new-password">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Plan Name<i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="plan_id" id="plan_id" class="form-control ">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="exampleSelectStatus">Status</label>
                                        <select class="form-control" id="exampleSelectStatus" name="is_active">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                        <a class="btn btn-light" href="<?= base_url('dashboard') ?>">Cancel</a>
                                    </div>
                                    <?php echo form_close(); ?>

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
                role_id: {
                    required: true
                },
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                password: {
                    required: true
                }
            },
            messages: {
                role_id: {
                    required: "Please select a user role"
                },
                name: {
                    required: "Please enter a name"
                },
                email: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address"
                },
                mobile: {
                    required: "Please enter a mobile number",
                    number: "Please enter a valid mobile number",
                    minlength: "Mobile number must be exactly 10 digits",
                    maxlength: "Mobile number must be exactly 10 digits"
                },
                password: {
                    required: "Please enter a password"
                }
            },
            errorClass: "error-text",
            errorElement: "span",
            submitHandler: function(form) {
                console.log("Form submitted successfully!");
                form.submit();
            }
        });

        $('#role_id').change(function() {
            var roleId = $(this).val();

            $.ajax({
                url: '<?= base_url('users/fetchplan') ?>',
                method: 'POST',
                data: {
                    role_id: roleId
                },
                success: function(response) {
                    console.log(response)
                    $('#plan_id').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>