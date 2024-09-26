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
                  <table class=" Notificationexample display nowrap table table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Message</th>
                        <th>Subject</th>
                        <th>Created On</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (!empty($notify)) {
                        $i = 1;
                        foreach ($notify as $row) {
                          $newDate = date("d-m-Y", strtotime($row['created_at']));
                      ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td class="wrap-text"><?= $row['message']; ?></td>
                            <td class="wrap-text"><?= $row['subject']; ?></td>
                            <td><?= $newDate; ?></td>
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

    // Optionally, you can also mark notifications as read in the backend via AJAX call
    // Example:
    $.ajax({
      url: '<?= base_url('markNotificationsAsRead') ?>',
      method: 'POST',
      data: {
        userId: <?= $row['user_id'] ?>
      },
      success: function(response) {
        // Handle response
      }
    });

    // Initialize DataTable with wrapped text in cells
    var table = $('.Notificationexample').DataTable({
      paging: true,
      lengthChange: false,
      pageLength: 20,
      searching: true,
      scrollX: true,
    });

  });
</script>