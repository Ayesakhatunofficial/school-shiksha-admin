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
                  <h4 class="card-title mb-3">Edit User</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('editusers'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder=""
                    value="<?= $users['id'] ?>">

                  <div class="form-group col-lg-6">
                    <label>User Roles <i class="mdi mdi-star color-danger"></i></label>

                    <select required name="role_id" id="" class="form-control">
                      <option value="">Select</option>
                      <?php foreach ($roles as $row) { ?>
                        <option value="<?= $row->id ?>" <?= $users['role_id'] == $row->id ? "selected" : "" ?>>
                          <?= ucwords(str_replace('_', ' ', $row->role_name)) ?>
                        </option>

                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Name<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="text" class="form-control" id="name" value="<?= $users['name'] ?? "" ?>"
                      placeholder="Enter a name" name="name">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Email<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="email" class="form-control" id="email" value="<?= $users['email'] ?? "" ?>"
                      placeholder="Enter an email" name="email" autocomplete="off">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="number" class="form-control" id="mobile" value="<?= $users['mobile'] ?? "" ?>"
                      placeholder="Enter a mobile no." name="mobile">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleSelectGender">Status</label>
                    <select name="is_active" class="form-control" id="exampleSelectGender">
                      <option value="1" <?= $users['is_active'] == "1" ? "selected" : "" ?>>Active</option>
                      <option value="0" <?= $users['is_active'] == "0" ? "selected" : "" ?>>Inactive</option>
                    </select>
                  </div>

                  <div class=" col-lg-12">
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
        name: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        mobile: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10
        },

      },
      messages: {
        role_id: {
          required: "Please select a user role"
        },
        name: {
          required: "Please enter a name"
        },
        email: {
          required: "Please enter an email address",
          email: "Please enter a valid email address"
        },
        mobile: {
          required: "Please enter a mobile number",
          number: "Please enter a valid mobile number",
          minlength: "Mobile number must be exactly 10 digits",
          maxlength: "Mobile number must be exactly 10 digits"
        },
      },
      errorClass: "error-text",
      errorElement: "span",
      submitHandler: function (form) {
        console.log("Form submitted successfully!");
        form.submit();
      }
    });
  });
</script>