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
                                <div class="col-lg-12 mr-2 row">
                                    <div class="form-group col-lg-4">
                                        <label for="">Txn Type</label>
                                        <select name="txn_type" id="txn_type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="cr">Credit</option>
                                            <option value="dr">Debit</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="" class="form-label">From Date <i class="mdi mdi-star color-danger"></i></label>
                                        <input type="date" class="form-control" name="from_date" id="from_date" value="<?= $from_date ?? '' ?>">
                                        <span id="from_date_error" class="text-danger"></span>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="" class="form-label">To Date <i class="mdi mdi-star color-danger"></i></label>
                                        <input type="date" class="form-control" name="to_date" id="to_date" value="<?= $to_date ?? '' ?>">
                                        <span id="to_date_error" class="text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-2 mt-2">
                                        <button class="btn btn-primary btn-sm mt-3" id="submit_btn">Submit</button>
                                    </div>

                                </div>
                                <div class="container">

                                    <table id="datatable-buttons" class="usersexample display nowrap table table-bordered" cellspacing="0" width="100%">
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
    $(document).ready(function() {
        var table = $('#datatable-buttons').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('wallet-history'); ?>",
                "type": "GET"
            },
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    $('row c[r^="C"]', sheet).attr('s', '2');
                }
            }]
        });

        $('#txn_type').on('change', function() {
            var service_id = $(this).val();
            table.column(1).search(service_id).draw();
        });

        $('#submit_btn').on('click', function() {
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var messageFromDate = $('#from_date_error');
            var messageToDate = $('#to_date_error');

            messageFromDate.text('');
            messageToDate.text('');

            if (fromDate === '') {
                messageFromDate.text("Please enter from date.");
            }
            if (toDate === '') {
                messageToDate.text("Please enter to date.");
            }

            if (fromDate && toDate) {
                table.column(2).search(fromDate).column(3).search(toDate).draw();
            }

        });
    });
</script>