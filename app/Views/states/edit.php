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
                  <h4 class="card-title mb-3">Edit States</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('editstates'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder="" value="<?= $states['id'] ?>">

                  <div class="form-group col-lg-6">
                    <label for="exampleInputName1">States Name <i class="mdi mdi-star color-danger"></i></label>
                    <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="States Name" value="<?= $states['name'] ?>">
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
        name: {
          required: true,
          noNumericValidation: true
        }
      },
      messages: {
        name: {
          required: "Please enter a states name",
          noNumericValidation: "Numeric values are not allowed in the name",
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