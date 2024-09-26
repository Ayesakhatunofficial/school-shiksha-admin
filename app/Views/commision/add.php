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
                                    <h4 class="card-title mb-3">Add Commission</h4>
                                    <?php echo form_open(base_url('addcommsion'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>

                                    <div class="form-group col-lg-6">
                                        <label>User Roles <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="role_id" id="" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($roles as $row) { ?>
                                                <option value="<?= $row['id'] ?>">
                                                    <?= ucwords(str_replace('_', ' ', $row['role_name'])) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Service Name<span style="color: red;">*</span></label>
                                        <select required class="form-control" data-live-search="true" id="service_id" name='service_id'>
                                            <option value="">Select</option>
                                            <?php foreach ($service as $index => $services) {
                                            ?>
                                                <option value="<?= $services->id ?>">
                                                    <?= isset($services->service_name) ? $services->service_name : ""; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Amount<i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="number" class="form-control" id="amount" placeholder="Amount" name="amount">
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

                amount: {
                    required: true,
                    number: true
                },
                service_id: {
                    required: true,
                }
            },
            messages: {
                role_id: {
                    required: "Please select a user role"
                },

                amount: {
                    required: "Please enter a amount",
                    number: "Please enter a valid number for amount"
                },
                service_id: {
                    required: "Please select a service"
                }
            },
            errorClass: "error-text",
            errorElement: "span",
            submitHandler: function(form) {
                console.log("Form submitted successfully!");
                form.submit();
            }
        });
    });
</script>