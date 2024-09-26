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
                            <h4 class="card-title mb-3"> Students</h4>
                            <div class="row">
                                <div class="col-lg-12 mr-2 row">
                                    <div class="form-group col-lg-6">
                                        <label for="">Referral</label>
                                        <select name="referral" id="referral" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">With Referral</option>
                                            <option value="0">Without Referral</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group col-lg-6">
                                        <label for="">Student Type</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">Select</option>
                                            <option value="">Free Student</option>
                                            <option value="">Paid Student</option>
                                        </select>
                                    </div> -->
                                </div>
                                <div class="container">

                                    <table id="datatable-buttons" class=" display nowrap table table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>Student Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>District</th>
                                                <th>Referral Code</th>
                                                <th>Status</th>
                                                <th>Action </th>
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
            "ajax": {
                "url": "<?php echo base_url('students'); ?>",
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


        $('#referral').on('change', function () {
            var referral = $('#referral').val();
            table.column(1).search(referral).draw();
        });
    </script>
</body>

</html>