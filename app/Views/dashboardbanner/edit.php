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
                  <h4 class="card-title mb-3">Edit Dashboard Banner</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('dashboard/editbanner'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder="" value="<?= $banner['id'] ?>">

                  <div class="form-group col-lg-6">
                    <label>User Role<i class="mdi mdi-star color-danger"></i></label>
                    <select required name="role_id" id="role_id" class="form-control" onchange="getService();">
                      <option value="">Select</option>
                      <?php foreach ($roles as $row) {
                        $role_name = getRole($banner['role_id']);
                      ?>
                        <option value="<?= $row['id'] ?>" <?= $row['role_name'] ==  $role_name ? 'selected' : ""; ?>>
                          <?= ucwords(str_replace('_', ' ', $row['role_name'])) ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Title<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="text" class="form-control" value="<?= $banner['title'] ?>" id="title" placeholder="Enter a title" name="title">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Image</label>
                    <input type="file" class="form-control" id="banner" accept="image/*" name="banner">
                    <a href="<?= $banner['banner']; ?>" target="_blank"><img src="<?= $banner['banner']; ?>" alt="" height="70px" width="100px"></a>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleSelectGender">Status</label>
                    <select name="is_active" class="form-control" id="exampleSelectGender">
                      <option value="1" <?= $banner['is_active'] == "1" ? "selected" : "" ?>>Active</option>
                      <option value="0" <?= $banner['is_active'] == "0" ? "selected" : "" ?>>Inactive</option>
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
        title: {
          required: true,
          noNumericValidation: true
        }
      },
      messages: {
        title: {
          required: "Please enter a title",
          noNumericValidation: "Numeric values are not allowed in the title",
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