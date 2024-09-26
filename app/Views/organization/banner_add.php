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
                  <h4 class="card-title mb-3">Add Organization Banner</h4>
                  <?php echo form_open(base_url('organization/addbanner/' . $organization_id ?? ""), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" name="organization_id" value="<?= $organization_id ?? "" ?>">

                  <div class="form-group col-lg-6">
                    <label>Image<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="file" class="form-control" id="banner_image" accept="image/*" name="banner_image">
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
        banner_image: {
          required: true,
        }
      },
      messages: {
        banner_image: {
          required: "Please select a image",
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

    // Custom validation method to disallow numeric values in the title field
    $.validator.addMethod("noNumericValidation", function(value, element) {
      return !/\d/.test(value);
    }, "Numeric values are not allowed.");
  });
</script>