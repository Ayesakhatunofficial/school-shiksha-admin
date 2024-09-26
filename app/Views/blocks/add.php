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
                                    <h4 class="card-title mb-3">Add Blocks</h4>
                                    <?php echo form_open(base_url('addBlocks'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>

                                    <div class="form-group col-lg-6">
                                        <label>State Name <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="states_id" id="states_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($states as $rows) { ?>
                                                <option value="<?= $rows['id'] ?>"><?= $rows['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label>District Name <i class="mdi mdi-star color-danger"></i></label>
                                        <select name="district_id" id="district_id" class="form-control">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Blocks Name <i class="mdi mdi-star color-danger"></i></label>
                                        <input type="text" class="form-control" id="name" placeholder="Blocks Name" name="name">
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
                states_id: {
                    required: true,
                },
                district_id: {
                    required: true,
                },
                name: {
                    required: true,
                }
            },
            messages: {
                states_id: {
                    required: "Please select a state",
                },
                district_id: {
                    required: "Please select a district",
                },
                name: {
                    required: "Please enter a blocks name",
                }
            },
            errorClass: "error-text",
            errorElement: "span",
            submitHandler: function(form) {
                console.log("Form submitted successfully!");
                form.submit();
            }
        });

        $.validator.addMethod("noNumericValidation", function(value, element) {
            return !/\d/.test(value);
        }, "Numeric values are not allowed.");

        $('#states_id').change(function() {
            var roleId = $(this).val();

            $.ajax({
                url: '<?= base_url('blocks/fetchUser') ?>',
                method: 'POST',
                data: {
                    role_id: roleId
                },
                success: function(response) {
                    $('#district_id').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>