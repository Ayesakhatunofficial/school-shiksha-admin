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
              <h4 class="card-title mb-3"> Notifications</h4>

              <div class="row">
                <div class="container">
                  <div>
                    <a href="<?= base_url('addnotification') ?>" class="btn btn-primary btn-sm mb-3"> Add</a>
                  </div>

                  <table class=" noiexample display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Users</th>
                        <!-- <th>Action</th> -->
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($notify)) {
                        $i = 1;
                        foreach ($notify as $row) {
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td class="wrap-text"><?= $row['subject']; ?></td>
                            <td class="wrap-text"><?= $row['message']; ?></td>
                            <td><?= $row['users_name']; ?></td>
                            <!-- <td>
                              <div class="main_curd">
                                <a href="< ?= base_url('notification/edit/' . $row['id']) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>
                              </div>
                            </td> -->
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
<script>
  $(document).ready(function() {
    // Initialize DataTable with wrapped text in cells
    var table = $('.noiexample').DataTable({
      paging: true,
      lengthChange: false,
      pageLength: 20,
      searching: true,
      scrollX: true,
    });

  });
</script>