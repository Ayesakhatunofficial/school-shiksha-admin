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

                <?= view('includes/msg.php') ?>

                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Send Withdraw Request</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->

                                    <form class="row" id="quickForm" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-lg-12">
                                            <label>Amount<i class="mdi mdi-star color-danger"></i></label>
                                            <input type="text" class="form-control" placeholder="Enter Amount" name="amount" value="<?= old('amount') ?>">

                                        </div>


                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                            <a class="btn btn-light" href="<?= base_url('dashboard') ?>">Cancel</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body container common_list_table">
                            <h4 class="card-title mb-3">Withdraw Status</h4>

                            <div class="row">
                                <div class="container">

                                    <table class="query display nowrap table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>Date</th>
                                                <th>Amount(₹)</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($withdrawals)) {
                                                $i = 1;
                                                foreach ($withdrawals as $withdraw) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= $withdraw->request_date; ?></td>
                                                        <td><?= $withdraw->amount; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($withdraw->status == 'rejected') { ?>
                                                                <a><label class="badge badge-danger">Rejected</label></a>
                                                            <?php } else if ($withdraw->status == 'approved') { ?>
                                                                <a><label class="badge badge-success">Approved</label></a>
                                                            <?php } else if ($withdraw->status == 'pending') { ?>
                                                                <a><label class="badge badge-warning">Pending</label></a>
                                                            <?php } ?>
                                                        </td>

                                                        <td class="wrappable"><?= $withdraw->remarks ?></td>
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

    <script>
        $(document).ready(function() {
            $('#quickForm').validate({
                rules: {
                    amount: {
                        required: true,
                        number: true,
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                        number: "Please enter a valid amount",
                    }
                },
                errorClass: "error-text",
                errorElement: "span",
                submitHandler: function(form) {
                    console.log("Form submitted successfully!");
                    form.submit();
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('.query').DataTable({
                paging: true,
                lengthChange: false,
                pageLength: 10,
                searching: true,
                scrollX: true, // Enable horizontal scrolling
            });
        });
    </script>

</body>

</html>