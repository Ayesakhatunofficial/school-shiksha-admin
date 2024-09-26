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
                  <h4 class="card-title mb-3">Edit Banner</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('editbanner'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder="" value="<?= $banner['id'] ?>">
                  <div class="form-group col-lg-6">
                    <label>Banner Types<i class="mdi mdi-star color-danger"></i></label>
                    <select required name="type_id" id="type_id" class="form-control" onchange="getService();">
                      <option value="">Select</option>
                      <?php foreach ($type as $row) { ?>
                        <option value="<?= $row['id'] ?>" <?= $row['id'] ==  $banner['type_id']  ? 'selected' : ""; ?>>
                          <?= ucwords(str_replace('_', ' ', $row['type'])) ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Image</label>
                    <input type="file" class="form-control" id="image" accept="image/*" name="image">
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
        type_id: {
          required: true,
        }
      },
      messages: {
        type_id: {
          required: "Please enter a Banner Type",
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