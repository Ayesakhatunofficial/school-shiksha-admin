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
                                    <h4 class="card-title mb-3">Add Plans</h4>
                                    <?php echo form_open(base_url('addplans'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>

                                    <div class="form-group col-lg-6">
                                        <label>User Roles <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="role_id" id="role_id" class="form-control" onchange="getService();">
                                            <option value="">Select</option>
                                            <?php foreach ($roles as $row) { ?>
                                                <option value="<?= $row['id'] ?>">
                                                    <?= ucwords(str_replace('_', ' ', $row['role_name'])) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label>Plan Name <i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="text" class="form-control" id="plan_name" placeholder="Plan Name" name="plan_name" value="<?= old('plan_name') ?>">
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label>Plan Amount <i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="number" class="form-control" id="plan_amount" placeholder="Plan Amount" name="plan_amount" value="<?= old('plan_amount') ?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="plan_duration">Plan Duration(Months) <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="plan_duration" id="" class="form-control">
                                            <option value="">Select Plan Duration</option>
                                            <option value="1">One Month</option>
                                            <option value="3">Three Months</option>
                                            <option value="6">Six Months</option>
                                            <option value="12">Twelve Month</option>
                                            <option value="24">Twenty four Months</option>
                                            <option value="36">Thirty six months</option>
                                            <option value="48">Forty Eight Months</option>
                                            <option value="60">Sixty Months</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6" id="service_list">
                                        <label>Service Name<i class="mdi mdi-star color-danger"></i></label>
                                        <select required multiple class="select2 form-control" data-live-search="true" id="service_id" name='service_id[]'>
                                            <?php foreach ($service as $index => $services) {
                                            ?>
                                                <option value="<?= $services->id ?>">
                                                    <?= isset($services->service_name) ? $services->service_name : ""; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="exampleSelectStatus">Status</label>
                                        <select class="form-control" id="exampleSelectStatus" name="is_active">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div id="addRowContainer" class="form-group col-lg-12" style="text-align: right;">
                                        <button type="button" class="btn btn-success add-TodaysDate">Add Row</button>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group col-lg-12" style="background-color: #b66dff;">
                                            <div class="card-header text-center">
                                                <label>Plan Description</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12 TodaysDateContainer">
                                        <div class="input-group">
                                            <input type="text" class="form-control plan-description" value="<?= old('plan_description[]') ?>" placeholder="Plan Description" name="plan_description[]">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-TodaysDate" style="display: none;">-</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" id="commid" style="display:none;">
                                        <div class="form-group col-lg-12" style="background-color: #b66dff;">
                                            <div class="card-header" style="text-align: center;">
                                                <label>Plan Commission</label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label>Users <i class="mdi mdi-star color-danger"></i></label>
                                                <select required name="commission_role_id" id="commission_role_id" class="form-control">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Commission Amount <i class="mdi mdi-star color-danger"></i></label>
                                                <input required type="number" name="amount" id="amount" value="<?= old('amount') ?>" class="form-control" placeholder="Enter Commission Amount">
                                            </div>
                                        </div>
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
    $('.select2').select2({
        placeholder: "Select Services", // Placeholder text
        allowClear: true // Allow the user to clear the selection
    });
</script>

<script>
    $(document).ready(function() {
        $('#quickForm').validate({
            rules: {
                role_id: {
                    required: true
                },
                plan_name: {
                    required: true
                },
                plan_amount: {
                    required: true,
                    number: true
                },
                service_id: {
                    required: true,
                },
                plan_duration: {
                    required: true,
                    digits: true,
                    min: 1
                },
                commission_role_id: {
                    required: true
                },
                amount: {
                    required: true
                },
            },
            messages: {
                role_id: {
                    required: "Please select user role"
                },
                plan_name: {
                    required: "Please enter plan name"
                },
                plan_amount: {
                    required: "Please enter plan amount",
                    number: "Please enter valid number for plan amount"
                },
                plan_duration: {
                    required: "Please select plan duration",
                    digits: "Please enter only digits (no decimals)",
                    min: "Plan duration must be at least 1 month"
                },
                commission_role_id: {
                    required: "Please select user role"
                },
                amount: {
                    required: "Please enter Commission Amount"
                },
            },
            errorClass: "error-text",
            errorElement: "span",
            submitHandler: function(form) {
                console.log("Form submitted successfully!");
                form.submit();
            }
        });

        $('.add-TodaysDate').click(function() {
            var newRow = $('.TodaysDateContainer').first().clone();
            newRow.find('.plan-description').val('');
            $('.TodaysDateContainer:last').after(newRow);
            $('.remove-TodaysDate').not(':first').show();
        });

        $(document).on('click', '.remove-TodaysDate', function() {
            $(this).closest('.TodaysDateContainer').remove();
            if ($('.remove-TodaysDate').length === 1) {
                $('.remove-TodaysDate').hide();
            }
        });

        $('.selectpicker').selectpicker();

        $('#role_id').change(function() {
            var roleId = $(this).val();
            console.log(roleId);
            $.ajax({
                url: '<?= base_url('plan/fetchUser') ?>',
                method: 'POST',
                data: {
                    role_id: roleId
                },
                success: function(response) {
                    $('#commission_role_id').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed');
                    console.error(xhr.responseText);
                }
            });

            if (roleId == 2) {
                $('#commid').hide();
            } else {
                $('#commid').show();
            }
        });

    });

    function getService() {
        var role_id = document.getElementById("role_id").value;

        if (role_id == 5) {
            $('#service_list').show();
        } else {
            $('#service_list').hide();
        }
    }

    window.onload = function() {
        document.getElementById("service_list").style.display = 'none';
    };
</script>

</script>