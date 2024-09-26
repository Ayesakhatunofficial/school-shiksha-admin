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

                                    <h4 class="card-title text-center text-primary mb-3"> User Withdraw Request</h4>
                                    <table id="details" class="display nowrap table table-bordered" cellspacing="0" width="100%">
                                        <?php if (!empty($withdraw)) { ?>
                                            <tbody>

                                                <tr>
                                                    <td>User Name</td>
                                                    <td><?= $withdraw->name ?></td>
                                                </tr>

                                                <tr>
                                                    <td>User Mobile</td>
                                                    <td><?= $withdraw->mobile ?></td>
                                                </tr>

                                                <tr>
                                                    <td>User Email</td>
                                                    <td><?= $withdraw->email ?></td>
                                                </tr>

                                                <tr>
                                                    <td>User Current Wallet Balance(₹)</td>
                                                    <td><?= $withdraw->wallet ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Request Date</td>
                                                    <td><?= $withdraw->request_date ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Request Amount(₹)</td>
                                                    <td><?= $withdraw->amount ?></td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    if (!empty($withdraw) && $withdraw->status != 'approved') {
                    ?>
                        <div class="card mt-3">
                            <div class="card-body container common_list_table">
                                <div class="row">
                                    <div class="container">

                                        <h4 class="card-title text-center text-primary mb-3"> Withdraw Status</h4>

                                        <form class="row" action="" method="post" enctype="multipart/form-data">
                                            <div class="form-group col-lg-12">
                                                <label>Change Status<i class="mdi mdi-star color-danger"></i></label>

                                                <select name="status" id="status_value" class="form-control" onclick="showRemarks()">
                                                    <option value="">select status</option>
                                                    <option value="pending" <?= ($withdraw->status == 'pending') ? "selected" : '' ?>>Pending</option>
                                                    <option value="approved" <?= ($withdraw->status == 'approved') ? "selected" : '' ?>>Approved</option>
                                                    <option value="rejected" <?= ($withdraw->status == 'rejected') ? "selected" : '' ?>>Rejected</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-lg-12" id="remark" style="display: none;">
                                                <label for="">Remarks</label>
                                                <textarea name="remarks" id="" class="form-control" placeholder="Enter Remarks"><?= isset($withdraw->remarks) ? $withdraw->remarks : '' ?></textarea>
                                            </div>

                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                                <a class="btn btn-light" href="<?= base_url('withdraw-request') ?>">Cancel</a>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
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
        function showRemarks() {
            var status = document.getElementById("status_value").value;
            if (status == 'rejected') {
                $('#remark').show();
            } else {
                $('#remark').hide();
            }
        }

        window.addEventListener("load", (event) => {
            var status = document.getElementById("status_value").value;
            if (status == 'rejected') {
                $('#remark').show();
            } else {
                $('#remark').hide();
            }
        });
    </script>

</body>

</html>