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
                                    <h4 class="card-title mb-3">Add District</h4>
                                    <?php echo form_open(base_url('addDistrict'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                                    <div class="form-group col-lg-6">
                                        <label>States <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="state_id" id="" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($states as $row) { ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>District Name <i class="mdi mdi-star color-danger"></i></label>
                                        <input type="text" class="form-control" id="name" placeholder="District Name" name="name">
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
                state_id: {
                    required: true,
                },
                name: {
                    required: true,
                }
            },
            messages: {
                state_id: {
                    required: "Please select the state",
                },
                name: {
                    required: "Please enter a district name",
                }
            },
            errorClass: "error-text",
            errorElement: "span",
            submitHandler: function(form) {
                // Optionally, perform additional client-side validation here
                console.log("Form submitted successfully!"); // Check if this message appears in the console
                form.submit(); // Submit the form if all validations pass
            }
        });

        // Custom validation method to disallow numeric values in the name field
        $.validator.addMethod("noNumericValidation", function(value, element) {
            return !/\d/.test(value);
        }, "Numeric values are not allowed.");

    });
</script>