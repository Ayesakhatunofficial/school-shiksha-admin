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
              <h4 class="card-title mb-3"> Blocks</h4>

              <div class="row">
                <div class="container">
                  <div>
                    <a href="<?= base_url('addBlocks') ?>" class="btn btn-primary btn-sm mb-3"> Add</a>
                  </div>

                  <table class=" example display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Blocks Name</th>
                        <th>District Name</th>
                        <th>State Name</th>
                        <th>Status</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($blocks)) {
                        $i = 1;
                        foreach ($blocks as $row) {
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['block_name']; ?></td>
                            <td><?= $row['district_name']; ?></td>
                            <td><?= $row['state_name']; ?></td>
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
                                <a href="<?= base_url('editDataBlocks/' . $row['block_id']) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="<?= base_url('delete/' . $row['block_id']) ?>" class="btn a-btn btn-inverse-danger btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are You Sure?')">
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