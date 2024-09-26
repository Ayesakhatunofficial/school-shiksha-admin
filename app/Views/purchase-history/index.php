<!DOCTYPE html>
<html lang="en">
<?php $session = session(); ?>

<?= view('includes/head.php') ?>

<body>

    <div class="container-scroller">

        <?= view('includes/header.php') ?>

        <div class="container-fluid page-body-wrapper">

            <?= view('includes/sidebar.php') ?>

            <!-- partial -->

            <div class="main-panel">

                <div class="content-wrapper">
                    <?= view('includes/msg.php') ?>

                    <div class="card">
                        <div class="card-body container common_list_table">
                            <h4 class="card-title mb-3">Purchase History</h4>

                            <div class="row">

                                <div class="col-lg-12 mr-2 row">

                                    <div class="form-group col-md-3">
                                        <h6 class="pt-4">Total Purchase: <span id="total_purchase_amount"><b>₹ 119,22</b></span></h6>
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

                                    <table id="datatable-buttons" class=" display nowrap table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Invoice Number</th>
                                                <th>Customer Name</th>
                                                <th>Txn No</th>
                                                <th>Purchase Date</th>
                                                <th>Amount(₹)</th>
                                                <th>Status</th>
                                                <th>Action</th>
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


    <script>
        var table = $('#datatable-buttons').DataTable({
            "processing": true,
            "serverSide": true,
            drawCallback: function (settings) {

                var searchValue = table.search();
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                const searchParms = new URLSearchParams();
                searchParms.append('from_date', fromDate);
                searchParms.append('to_date', toDate);
                searchParms.append('search_string', searchValue);

                const url = '<?= base_url('purchase-history/total-purchase') ?>';
                fetch(`${url}?${searchParms.toString()}`)
                .then( res => res.json() )
                .then( res => {
                    $('#total_purchase_amount').text(res?.data?.total);
                })
                .catch( err => {
                    console.log(err)
                });
            },
            columns: [
                { "data": "invoice_number", "orderable" : false, "searchable": true},
                { "data": "customer_name" , "orderable" : false, "searchable": true},
                { "data": "txn_id" , "orderable" : false, "searchable": true},
                { "data": "purchase_date", "orderable" : false, "searchable": true},
                { "data": "amount" , "orderable" : false, "searchable": false},
                { "data": "status", "orderable" : false, "searchable": false},
                { "data": "action", "orderable" : false, "searchable": false}
            ],
            "ajax": {
                "url": "<?php echo base_url('purchase-history'); ?>",
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
                table.column(1).search(fromDate).column(2).search(toDate).draw();
            }
        });
    </script>
</body>

</html>