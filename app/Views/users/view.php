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
              <h4 class="card-title mb-3"> <?= ucwords(str_replace('_', ' ', $plans[0]['role_name'] ?? "")); ?></h4>

              <div class="row">
                <div class="container">
                  <div>
                    <a href="<?= base_url('addusers') ?>" class="btn btn-primary btn-sm mb-3"> Add</a>
                  </div>

                  <table class="example display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>User Id</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>email</th>
                        <th>User Role</th>
                        <th>Membership Plan</th>
                        <th>Status</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($users)) {
                        $i = 1;
                        foreach ($users as $row) {
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['mobile']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= ucwords(str_replace('_', ' ', $row['role_name'])); ?></td>
                            <td class="wrap-text"><?= $row['plan_name'] ?></td>
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
                                <a href="<?= base_url('editDatausers/' . $row['id']) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>

                                <a href="<?= base_url('user/view/' . $row['id']) ?>" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                  <i class="mdi mdi-eye"></i>
                                </a>

                                <a href="<?= base_url('user/' . $row['id'] . '/bank_details') ?>" class="btn a-btn btn-inverse-warning btn-rounded btn-icon" title="Bank Details">
                                  <i class="mdi mdi-bank"></i>
                                </a>

                                <a href="<?= base_url('deleteusers/' . $row['id']) ?>" class="btn a-btn btn-inverse-danger btn-rounded btn-icon" onclick="return confirm('Are You Sure?')" title="Delete">
                                  <i class="mdi mdi-delete"></i></a>

                                <a href="<?= base_url('user/plan/' . $row['id']) ?>" class="ml-1 btn a-btn btn-inverse-danger btn-rounded btn-icon" alt="plan" title="Plan">
                                  <i class="mdi mdi-notebook-outline"></i>
                                </a>

                                <a href="<?= base_url('user/' . $row['id'] . '/invoice') ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" title="Invoice">
                                  <i class="mdi mdi-file"></i>
                                </a>
                                <a href="<?= base_url('user/' . $row['id'] . '/wallet') ?>" class="btn a-btn btn-inverse-warning btn-rounded btn-icon" title="Wallet Transaction">
                                  <i class="mdi mdi-wallet"></i>
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
