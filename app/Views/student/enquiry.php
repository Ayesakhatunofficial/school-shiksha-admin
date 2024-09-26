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
                            <h4 class="card-title mb-3">Student's Enquiry</h4>

                            <div class="row">

                                <div class="col-lg-12 mr-2 row">
                                    <div class="form-group col-lg-6">
                                        <label for="">Service</label>
                                        <select name="service" id="service" class="form-control">
                                            <option value="">Select</option>
                                            <?php if (!empty($services)) {
                                                foreach ($services as $service) { ?>
                                                    <option value="<?= $service->id ?>"><?= $service->service_name ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="container">

                                    <table id="datatable-buttons" class=" display nowrap table table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>Student Details</th>
                                                <th>Service Name</th>
                                                <th>Service Commission(₹)</th>
                                                <th>Submit Date</th>
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
                "url": "<?php echo base_url('student/enquiry'); ?>",
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

        $('#service').on('change', function () {
            var service_id = $('#service').val();
            table.column(1).search(service_id).draw();
        });
    </script>
</body>

</html>