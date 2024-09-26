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
                  <h4 class="card-title mb-3">Edit Blocks</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('editBlocks'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder=""
                    value="<?= $blocks['id'] ?>">

                  <div class="form-group col-lg-6">
                    <label>State Name <i class="mdi mdi-star color-danger"></i></label>
                    <select required name="states_id" id="states_id" class="form-control">
                      <option value="">Select</option>
                      <?php foreach ($states as $rows) { ?>
                        <option value="<?= $rows['id'] ?>" <?= $rows['id'] == $blocks['state_id'] ? "selected" : "" ?>>
                          <?= $rows['name'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-6">
                    <label>District Name <i class="mdi mdi-star color-danger"></i></label>
                    <select name="district_id" id="district_id" class="form-control">
                      <option value="<?= $blocks['district_id'] ?>"><?= $blocks['district_name'] ?></option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Blocks Name <i class="mdi mdi-star color-danger"></i></label>
                    <input type="text" class="form-control" id="blocksname" value="<?= $blocks['name'] ?>"
                      placeholder="Blocks Name" name="name">
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="exampleSelectGender">Status</label>
                    <select name="is_active" class="form-control" id="exampleSelectGender">
                      <option value="1" <?= $blocks['is_active'] == "1" ? "selected" : "" ?>>Active</option>
                      <option value="0" <?= $blocks['is_active'] == "0" ? "selected" : "" ?>>Inactive</option>
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
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
      submitHandler: function (form) {
        // Optionally, perform additional client-side validation here
        console.log("Form submitted successfully!"); // Check if this message appears in the console
        form.submit(); // Submit the form if all validations pass
      }
    });

    // Custom validation method to disallow numeric values in the name field
    $.validator.addMethod("noNumericValidation", function (value, element) {
      return !/\d/.test(value);
    }, "Numeric values are not allowed.");

    $('#states_id').change(function () {
      var roleId = $(this).val(); // Get the selected role ID

      // Perform AJAX call
      $.ajax({
        url: '<?= base_url('blocks/fetchUser') ?>', // Replace with your AJAX endpoint
        method: 'POST', // or 'GET', depending on your server configuration
        data: {
          role_id: roleId
        },
        success: function (response) {
          // Handle successful response
          $('#district_id').html(response);
        },
        error: function (xhr, status, error) {
          // Handle error
          console.error('AJAX request failed');
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>