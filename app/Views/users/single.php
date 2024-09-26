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
                            <h4 class="card-title mb-3">View User</h4>
                            <div class="row">
                                <div class="container">

                                    <h4 class="card-title text-center text-primary mb-3">User Details</h4>
                                    <table id="example" class="display nowrap table table-bordered" cellspacing="0" width="100%">

                                        <tbody>

                                            <tr>
                                                <td>User Name</td>
                                                <td>
                                                    <?= $user->name ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Moblie Number</td>
                                                <td>
                                                    <?= $user->mobile ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Email ID</td>
                                                <td>
                                                    <?= $user->email ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>User Role</td>
                                                <td>
                                                    <?= ucwords(str_replace('_', ' ', $user->role_name)) ?>
                                                </td>
                                            </tr>

                                            <?php
                                            $loguser =   getUserData();
                                            $loguserRole = getRole($loguser->role_id);

                                            if ($loguserRole == ROLE_SUPER_ADMIN) { ?>

                                                <tr>
                                                    <td>Created By</td>
                                                    <td><?= $created_by->name ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Password</td>
                                                    <td><?= $user->raw_password ?></td>
                                                </tr>

                                            <?php } ?>

                                            <?php if ($user->role_name == ROLE_MASTER_DISTRIBUTOR) { ?>

                                                <tr>
                                                    <td>Total Distributor</td>
                                                    <td><?= $distributor->total_distributor ?></td>
                                                </tr>

                                            <?php }
                                            if ($user->role_name == ROLE_MASTER_DISTRIBUTOR || $user->role_name == ROLE_DISTRIBUTOR) { ?>

                                                <tr>
                                                    <td>Total Agent</td>
                                                    <td><?= $agent->total_agent ?></td>
                                                </tr>

                                            <?php }
                                            if ($user->role_name == ROLE_MASTER_DISTRIBUTOR || $user->role_name == ROLE_DISTRIBUTOR || $user->role_name == ROLE_AFFILATE_AGENT) { ?>

                                                <tr>
                                                    <td>Total Student</td>
                                                    <td><?= $student->total_student ?></td>
                                                </tr>
                                            <?php } ?>
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