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
              <h4 class="card-title mb-3"> Wallet History</h4>

              <div class="row">
                <div class="container">

                  <table id="datatable-buttons" class="usersexample display nowrap table table-bordered" cellspacing="0"
                    width="100%">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Txn Date </th>
                        <th>Reference No</th>
                        <th>Amount(₹)</th>
                        <th>Txn Type</th>
                        <th>Commission From</th>
                        <th>Txn Comment</th>
                      </tr>
                    </thead>

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
  var table = $('#datatable-buttons').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "<?php echo base_url('user/' . $id . '/wallet'); ?>",
      "type": "GET"
    },
    scrollX: true,
    dom: 'Bfrtip',
    buttons: [{
      extend: 'excelHtml5',
      customize: function (xlsx) {
        var sheet = xlsx.xl.worksheets['sheet1.xml'];

        $('row c[r^="C"]', sheet).attr('s', '2');
      }
    }]
  });
</script>