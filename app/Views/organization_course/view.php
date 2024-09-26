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
              <h4 class="card-title mb-3"> Organization Courses</h4>

              <div class="row">
                <div class="container">
                  <?php $ids = $organization_id ?? ""; ?>
                  <div style="display: flex; justify-content: space-between;">
                    <a href="<?= base_url('organization/addcourse/' . $ids) ?>" class="btn btn-primary btn-sm mb-3">
                      Add</a>
                    <a href="<?= base_url('organization/view') ?>" class="btn btn-primary btn-sm mb-3">
                      Back
                    </a>
                  </div>

                  <table class=" example display nowrap table table-bordered" id="example2" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Organization Name</th>
                        <th>Course Name</th>
                        <th>Course Amount</th>
                        <th>Register Through</th>
                        <th>Last Submission Date</th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($organization_course)) {
                        $i = 1;
                        foreach ($organization_course as $row) {
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['organization_name']; ?></td>
                            <td><?= $row['courses_name']; ?></td>
                            <td><?= $row['course_fees']; ?></td>
                            <td><?= ucwords(str_replace('_', ' ', $row['register_through'])); ?></td>
                            <td><?= $row['last_submission_date']; ?></td>
                            <td>
                              <div class="main_curd">
                                <a href="<?= base_url('/organization/editcourse/' . $row['id'] . "/orgnization_id" . "/" . $row['organization_id']) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="<?= base_url('deletecourseOrg/' . $row['id']) . "/orgnization_id" . "/" . $row['organization_id'] ?>" class="btn a-btn btn-inverse-danger btn-rounded btn-icon" onclick="return confirm('Are You Sure?')" data-toggle="tooltip" data-placement="top" title="Delete">
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