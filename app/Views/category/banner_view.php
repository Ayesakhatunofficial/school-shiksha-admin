<!DOCTYPE html>
<html lang="en">
<?php $session = session(); ?>

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

          <div class="card">
            <div class="card-body container common_list_table">
              <h4 class="card-title mb-3">Service Banner</h4>
              <?php $ids = $service_id ?? ""; ?>

              <div class="row">
                <div class="container">
                  <div style="display: flex; justify-content: space-between;">
                    <a href="<?= base_url('service/addbanner/' . $ids) ?>" class="btn btn-primary btn-sm mb-3">
                      Add</a>
                    <a href="<?= base_url('/category/view') ?>" class="btn btn-primary btn-sm mb-3">
                      Back
                    </a>
                  </div>

                  <table class=" example display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($service_banner)) {
                        $i = 1;
                        foreach ($service_banner as $row) {
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><a href="<?= $row['banner_image']; ?>" target="_blank"><img src="<?= $row['banner_image']; ?>" alt="" height="100px" width="100px"></a></td>
                            <td>
                              <?php if ($row['is_active'] == 0) { ?>
                                <a href="javascript:void(0);">
                                  <label class="badge badge-danger">Inactive</label>
                                </a>
                              <?php } else if ($row['is_active'] == 1) { ?>
                                <a href="javascript:void(0);">
                                  <label class="badge badge-success">Active</label>
                                </a>
                              <?php } ?>
                            </td>
                            <td>
                              <div class="main_curd">
                                <a href="<?= base_url('/service/editbanner/' . $row['id'] . "/service_id" . "/" . $row['service_id']) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="<?= base_url('deletebanner/' . $row['id']) . "/service_id" . "/" . $row['service_id'] ?>" class="btn a-btn btn-inverse-danger btn-rounded btn-icon" onclick="return confirm('Are You Sure?')" data-toggle="tooltip" data-placement="top" title="Delete">
                                  <i class="mdi mdi-delete"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                      <?php $i++;
                        }
                      } ?>
                    </tbody>
                  </table>
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