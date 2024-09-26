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
                            <h4 class="card-title mb-3">Invoice - <?= $purchase->uniq_invoice_id ?></h4>
                            <div class="row">
                                <div class="container">

                                    <h4 class="card-title text-center text-primary mb-3">Purchase Details</h4>
                                    <table id="example" class="display nowrap table table-bordered" cellspacing="0" width="100%">

                                        <tbody>
                                            <tr>
                                                <td>Invoice Number</td>
                                                <td><?= $purchase->uniq_invoice_id ?></td>
                                            </tr>

                                            <tr>
                                                <td>Customer Name</td>
                                                <td><?= $purchase->customer_name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Purchase Date</td>
                                                <td><?= $purchase->invoice_date ?></td>
                                            </tr>

                                            <tr>
                                                <td>Amount</td>
                                                <td><?= number_format($purchase->total) ?></td>
                                            </tr>

                                            <tr>
                                                <td>Payment Status</td>
                                                <td><?= ucfirst($purchase->status) ?></td>
                                            </tr>

                                            <tr>
                                                <td>Plan Name</td>
                                                <td><?= $purchase->items[0]->item_description ?></td>
                                            </tr>

                                            <tr>
                                                <td>Txn No</td>
                                                <td><?= $purchase->payment_txn_id ?></td>
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