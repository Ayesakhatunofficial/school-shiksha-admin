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

                                    <h4 class="card-title text-center text-primary mb-3">Membership Plan</h4>

                                    <table id="example" class="display nowrap table table-bordered" cellspacing="0" width="100%">

                                        <?php if (!empty($plan)) { ?>
                                            <tbody>

                                                <tr>
                                                    <td>Plan Name</td>
                                                    <td><?= $plan->plan_name ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Plan Duration</td>
                                                    <td><?= $plan->plan_interval_count . ' ' . $plan->plan_interval ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Plan Amount</td>
                                                    <td> ₹ <?= $plan->plan_amount ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Start Date</td>
                                                    <td><?= (new DateTime($plan->plan_period_start))->format('d-m-Y H:i:s a') ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>End Date</td>
                                                    <td><?= (new DateTime($plan->plan_period_end))->format('d-m-Y H:i:s a') ?>
                                                    </td>

                                                </tr>


                                            </tbody>

                                        <?php } else { ?>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>
                                                        No Active Plan
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>
                                    </table>

                                    <div>
                                        <a href="<?= base_url('user/buy-subscription/' . $user_id) ?>" class="btn btn-primary mt-3">Buy or Renew Subscription</a>
                                    </div>
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