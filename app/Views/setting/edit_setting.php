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
                  <h4 class="card-title mb-3">Settings</h4>

                  <?php echo form_open(base_url('setting_edit'), 'class="quick needs-validation" method="POST" enctype="multipart/form-data" id="settingForm" '); ?>

                  <div class="form-group">
                    <label>Logo <i class="mdi mdi-star color-danger"></i>:</label>
                    <input type="file" accept="image/*" name="company_logo" />
                  </div>

                  <div class="form-group">
                    <label>Company Name <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="company_name" value="<?= getSettingValue('company_name', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>Company Address <i class="mdi mdi-star color-danger"></i>:</label>
                    <textarea required name="company_address" class="form-control"> <?= getSettingValue('company_address', $setting) ?> </textarea>
                  </div>

                  <div class="form-group">
                    <label>Customer Support Mobile No. <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="support_phone" value="<?= getSettingValue('support_phone', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>Customer Support Email <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="support_email" value="<?= getSettingValue('support_email', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>Customer Support Whatsapp No. <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="support_whatsapp_no" value="<?= getSettingValue('support_whatsapp_no', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>SMTP Host <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="smtp_host" value="<?= getSettingValue('smtp_host', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>SMTP Username <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="smtp_username" value="<?= getSettingValue('smtp_username', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>SMTP Password <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="smtp_pass" value="<?= getSettingValue('smtp_pass', $setting) ?>" class="form-control" />
                  </div>

                  <div class="form-group">
                    <label>SMTP Port <i class="mdi mdi-star color-danger"></i>:</label>
                    <input required type="text" name="smtp_port" value="<?= getSettingValue('smtp_port', $setting) ?>" class="form-control" />
                  </div>

                  <!-- <div class="form-group">
                    <label>Career Guidence Text <i class="mdi mdi-star color-danger"></i>:</label>
                    <textarea required id="cgtext" name="cgtext" class="ckeditor form-control"><//?= getSettingValue('cgtext', $setting) ?></textarea>
                  </div> -->

                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update Settings</button>
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
    $('#settingForm').validate({
      rules: {
        support_phone: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10
        },
        support_email: {
          required: true,
          email: true
        },
        support_whatsapp_no: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10
        },
        smtp_host: {
          required: true
        },
        smtp_username: {
          required: true
        },
        smtp_pass: {
          required: true
        },
        smtp_port: {
          required: true,
          number: true
        }
      },
      messages: {
        support_phone: {
          required: "Please enter customer support mobile",
          number: "Please enter a valid Mobile number",
          minlength: "Mobile number must be 10 digits",
          maxlength: "Mobile number must be 10 digits"
        },
        support_email: {
          required: "Please enter customer support email",
          email: "Please enter a valid email address"
        },
        support_whatsapp_no: {
          required: "Please enter customer support WhatsApp number",
          number: "Please enter a valid WhatsApp number",
          minlength: "WhatsApp number must be 10 digits",
          maxlength: "WhatsApp number must be 10 digits"
        },
        smtp_host: {
          required: "Please enter SMTP host"
        },
        smtp_username: {
          required: "Please enter SMTP username"
        },
        smtp_pass: {
          required: "Please enter SMTP password"
        },
        smtp_port: {
          required: "Please enter SMTP port",
          number: "Please enter a valid SMTP port"
        }
      },
      errorClass: "text-danger",
      errorElement: "span",
      submitHandler: function(form) {
        console.log("Form submitted successfully!");
        form.submit();
      }
    });

  });
</script>