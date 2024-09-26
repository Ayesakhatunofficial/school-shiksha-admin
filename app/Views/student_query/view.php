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

          <div class="card">
            <div class="card-body container common_list_table">
              <h4 class="card-title mb-3"> Student's Query</h4>

              <div class="row">
                <div class="container">

                  <table class="example display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Message</th>
                        <th>Name</th>
                        <th>Mobile No.</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($query)) {
                        $i = 1;
                        foreach ($query as $row) {
                          ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td class="wrap-text"><?= $row['message']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['mobile']; ?></td>
                            <td><?= $row['email']; ?></td>
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
