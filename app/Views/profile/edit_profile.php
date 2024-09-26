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
                <!-- /.card-header -->
                <div class="card-body">
                  <h4 class="card-title mb-3">Profile</h4>

                  <?php echo form_open(base_url('profile_edit/' . $profile['id'] ?? ""), 'class="quick needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>

                  <?php
                  if ($role == ROLE_AFFILATE_AGENT) {
                  ?>
                    <div class="form-group">
                      <label for="">Referral Code</label>
                      <input type="text" class="form-control" value="<?= $profile['username'] ?? "" ?>" readonly>
                    </div>
                  <?php } ?>

                  <div class="form-group ">
                    <label>Name<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="text" class="form-control" value="<?= $profile['name'] ?? "" ?>" id="name" placeholder="Enter a name" name="name">
                  </div>

                  <div class="form-group ">
                    <label>Email<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="email" class="form-control" value="<?= $profile['email'] ?? "" ?>" id="email" placeholder="Enter an email" name="email" autocomplete="off">
                  </div>

                  <div class="form-group ">
                    <label>Mobile No.<i class="mdi mdi-star color-danger"></i></label>
                    <input required type="number" class="form-control" value="<?= $profile['mobile'] ?? "" ?>" id="mobile" placeholder="Enter a mobile no." name="mobile">
                  </div>

                  <div class="form-group ">
                    <label>Password(Change Password)</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter a password" name="password" autocomplete="new-password">
                  </div>

                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update </button>
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
        }
      },
      messages: {
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