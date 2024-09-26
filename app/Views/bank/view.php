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

                                    <h4 class="card-title text-center text-primary mb-3">User Bank Details</h4>
                                    <table id="example" class="example display nowrap table table-bordered"
                                        cellspacing="0" width="100%">


                                        <tbody>

                                            <tr>
                                                <td>Bank Name</td>
                                                <td>
                                                    <?= $bank->bank_name ?? '' ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Branch Name</td>
                                                <td>
                                                    <?= $bank->branch_name ?? '' ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Account Number</td>
                                                <td>
                                                    <?= $bank->account_number ?? '' ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>IFSC Code </td>
                                                <td>
                                                    <?= $bank->ifsc_code ?? '' ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Passbook Details Photo </td>
                                                <td>
                                                    <?php if (isset($bank->passbook_photo)) { ?>
                                                        <img src="<?= $bank->passbook_photo ?>" alt="" height="80"
                                                            width="100">
                                                    <?php } ?>
                                                </td>
                                            </tr>

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