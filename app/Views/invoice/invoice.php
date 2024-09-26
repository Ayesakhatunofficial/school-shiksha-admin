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
                            <h4 class="card-title mb-3"> Invoices</h4>

                            <div class="row">
                                <div class="container">

                                    <table class=" example display nowrap table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>Invoice Id</th>
                                                <th>Invoice Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($invoices)) {
                                                $i = 1;
                                                foreach ($invoices as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= $row->uniq_invoice_id; ?></td>
                                                        <td><?= $row->invoice_date; ?></td>
                                                        <td><?= $row->total; ?></td>
                                                        <td>
                                                            <?php if ($row->status == 'paid') { ?>
                                                                <button class="btn btn-success btn-sm"><?= ucwords($row->status); ?></button>
                                                            <?php } else if ($row->status == 'unpaid') { ?>
                                                                <button class="btn btn-danger btn-sm"><?= ucwords($row->status); ?></button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <div class="main_curd">
                                                                <a href="<?= base_url('student/' . $user_id . '/invoice/view/' . $row->id) ?>" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </a>

                                                            </div>
                                                        </td>
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

</body>

</html>