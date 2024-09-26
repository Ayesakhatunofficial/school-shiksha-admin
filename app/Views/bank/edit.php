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
                                    <h4 class="card-title mb-3"> User Bank Details</h4>
                                    <?php echo form_open(base_url('user/bank_details'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                                    <input type="hidden" value="<?= isset($bank->id) ? $bank->id : '' ?>" name="id">

                                    <div class="form-group col-lg-6">
                                        <label> Bank Name </label>
                                        <input required type="text" class="form-control" id="bank_name" placeholder="Enter Bank name" name="bank_name" value="<?= isset($bank->bank_name) ? $bank->bank_name : '' ?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label> Branch Name </label>
                                        <input required type="text" class="form-control" id="branch_name" placeholder="Enter Branch Name" name="branch_name" value="<?= isset($bank->branch_name) ? $bank->branch_name : '' ?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label>Account Number</label>
                                        <input required type="text" class="form-control" placeholder="Enter Account Number" name="account_number" value="<?= isset($bank->account_number) ? $bank->account_number : '' ?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label> IFSC Code</label>
                                        <input required type="text" class="form-control" placeholder="Enter IFSC Code" name="ifsc_code" value="<?= isset($bank->ifsc_code) ? $bank->ifsc_code : '' ?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label> Passbook Details </label>
                                        <input type="file" class="form-control" name="passbook">
                                        <div><?= isset($bank->passbook_photo) ? $bank->passbook_photo : '' ?></div>
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
                bank_name: {
                    required: true
                },
                branch_name: {
                    required: true
                },
                account_number: {
                    required: true,
                },
                ifsc_code: {
                    required: true
                }
            },
            messages: {
                bank_name: {
                    required: "Please enter bank name"
                },
                branch_name: {
                    required: "Please enter branch name"
                },
                account_number: {
                    required: "Please enter account number"
                },
                ifsc_code: {
                    required: "Please enter IFSC Code"
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