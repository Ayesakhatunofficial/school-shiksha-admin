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

          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-3">Edit District</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('editDistrict'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder="" value="<?= $district['id'] ?>">
                  <div class="form-group col-lg-6">
                    <label>States <i class="mdi mdi-star color-danger"></i></label>
                    <select required name="state_id" id="" class="form-control">
                      <option value="">Select</option>
                      <?php foreach ($states as $row) { ?>
                        <option value="<?= $row['id'] ?>" <?= $district['state_id'] == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="exampleInputName1">District Name <i class="mdi mdi-star color-danger"></i></label>
                    <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="District Name" value="<?= $district['name'] ?>">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleSelectGender">Status</label>
                    <select name="is_active" class="form-control" id="exampleSelectGender">
                      <option value="1" <?= $district['is_active'] == "1" ? "selected" : "" ?>>Active</option>
                      <option value="0" <?= $district['is_active'] == "0" ? "selected" : "" ?>>Inactive</option>
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