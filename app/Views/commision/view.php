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
              <h4 class="card-title mb-3"> Commissions</h4>

              <div class="row">
                <div class="container">
                  <div>
                    <a href="<?= base_url('addcommsion') ?>" class="btn btn-primary btn-sm mb-3"> Add</a>
                  </div>

                  <table class=" example display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>User Role</th>
                        <th>Service Name</th>
                        <th>Amount</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($plans)) {
                        $i = 1;
                        foreach ($plans as $row) {
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= ucwords(str_replace('_', ' ', $row['role_name'])); ?></td>
                            <td><?= $row['service_name']; ?></td>
                            <td><?= $row['amount']; ?></td>

                            <td>
                              <div class="main_curd">
                                <a href="<?= base_url('editDatacommsion/' . $row['id']) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="<?= base_url('deletecommsion/' . $row['id']) ?>" class="btn a-btn btn-inverse-danger btn-rounded btn-icon" onclick="return confirm('Are You Sure?')" data-toggle="tooltip" data-placement="top" title="Delete">
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