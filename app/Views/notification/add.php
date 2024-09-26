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
                                    <h4 class="card-title mb-3"> Notification</h4>
                                    <?php echo form_open(base_url('addnotification'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>

                                    <div class="form-group col-lg-6">
                                        <label>User Roles <i class="mdi mdi-star color-danger"></i></label>
                                        <select required name="role_id" id="role_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($roles as $row) { ?>
                                                <option value="<?= $row['id'] ?>">
                                                    <?= ucwords(str_replace('_', ' ', $row['role_name'])) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <?php
                                    $role_id = getRoleId(ROLE_STUDENT);
                                    ?>

                                    <input type="hidden" value="<?= $role_id ?>" name="hidden_role" id="hidden_role">

                                    <div class="form-group col-lg-6 " id="class_div" style="display: none" ;>
                                        <label for="">Class <i class="mdi mdi-star color-danger"></i></label>
                                        <select name="class" id="class_id" class="form-control">
                                            <option value="">-- Select Class --</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label>Users<i class="mdi mdi-star color-danger"></i></label>
                                        <select required multiple name="user_id[]" data-live-search="true" id="user_id"
                                            class="form-control select2">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label>Subject<i class="mdi mdi-star color-danger"></i></label>
                                        <input required type="text" class="form-control" id="subject"
                                            placeholder="Enter a subject" name="subject">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Message</label>
                                        <textarea class="form-control" id="message" placeholder="Enter an message"
                                            name="message"></textarea>
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
    $(document).ready(function () {
        $('#quickForm').validate({
            rules: {
                role_id: {
                    required: true
                },
                user_id: {
                    required: true
                },
                subject: {
                    required: true
                },
                class: {
                    required: true
                }

            },
            messages: {
                role_id: {
                    required: "Please select a user role"
                },
                user_id: {
                    required: "Please select a user"
                },
                subject: {
                    required: "Please enter a subject"
                },
                class: {
                    required: "Please select a class"
                }

            },
            errorClass: "error-text",
            errorElement: "span",
            submitHandler: function (form) {
                console.log("Form submitted successfully!");
                form.submit();
            }
        });

        $('#role_id').change(function () {
            var roleId = $(this).val();

            var stud_role = document.getElementById('hidden_role').value;

            if (roleId == stud_role) {
                document.getElementById("user_id").disabled = true;
                document.getElementById("class_div").style.display = 'block';

                $.ajax({
                    url: "<?= base_url('notification/class') ?>",
                    method: "POST",
                    data: {},
                    dataType: "json",
                    success: function (data) {
                        $('#class_id').html('<option value="">Select Class</option>');
                        $.each(data, function (key, value) {
                            $('#class_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });

            } else {

                $.ajax({
                    url: '<?= base_url('notification/fetchUser') ?>',
                    method: 'POST',
                    data: {
                        role_id: roleId
                    },
                    success: function (response) {
                        $('#user_id').html(response);
                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX request failed');
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        $('.select2').select2({
            placeholder: "Select Users", // Placeholder text
            allowClear: true // Allow the user to clear the selection
        });
    });
</script>