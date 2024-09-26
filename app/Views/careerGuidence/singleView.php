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
              <div class="row">
                <div class="container">

                  <h4 class="card-title text-center text-primary mb-3"> Career Guidance Details</h4>
                  <table id="details" class="display nowrap table table-bordered" cellspacing="0" width="100%">
                    <tbody>
                      <?php
                      if (!empty($career) && !is_null($career)) {
                      ?>
                        <tr>
                          <td>Name</td>
                          <td><?= $career->name ?></td>
                        </tr>
                        <tr>
                          <td>Email</td>
                          <td><?= $career->email ?></td>
                        </tr>
                        <tr>
                          <td>Mobile</td>
                          <td><?= $career->mobile ?></td>
                        </tr>
                        <tr>
                          <td>Gurdian Name</td>
                          <td><?= $career->guardian_name ?></td>
                        </tr>
                        <tr>
                          <td>Whatsapp Number</td>
                          <td><?= $career->whatsapp_number ?></td>
                        </tr>
                        <tr>
                          <td>Secondary Percentage</td>
                          <td><?= $career->mp_percentage ?></td>
                        </tr>
                        <tr>
                          <td>Higher Secondary Percentage</td>
                          <td><?= $career->hs_percentage ?></td>
                        </tr>
                        <tr>
                          <td>Stream</td>
                          <td><?= $career->stream ?></td>
                        </tr>
                        <tr>
                          <td>Interest Course Name</td>
                          <td><?= $career->interest_course_name ?></td>
                        </tr>
                      <?php } ?>
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