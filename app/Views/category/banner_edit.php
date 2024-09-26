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
                  <h4 class="card-title mb-3">Edit Service Banner</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('service/editbanner'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" name="hidden_id" value="<?= $bannerSer['id'] ?? "" ?>">
                  <input type="hidden" name="ser_id" value="<?= $bannerSer['service_id'] ?? "" ?>">

                  <div class="form-group col-lg-6">
                    <label>Image</label>
                    <input type="file" class="form-control" id="banner_image" accept="image/*" name="banner_image">
                    <a href="<?= $bannerSer['banner_image']; ?>" target="_blank"><img src="<?= $bannerSer['banner_image']; ?>" alt="" height="70px" width="100px"></a>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleSelectGender">Status</label>
                    <select name="is_active" class="form-control" id="exampleSelectGender">
                      <option value="1" <?= $bannerSer['is_active'] == "1" ? "selected" : "" ?>>Active</option>
                      <option value="0" <?= $bannerSer['is_active'] == "0" ? "selected" : "" ?>>Inactive</option>
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