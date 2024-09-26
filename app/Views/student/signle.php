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
                            <h4 class="card-title mb-3">View Student</h4>
                            <div class="row">
                                <div class="container">

                                    <h4 class="card-title text-center text-primary mb-3">Student Details</h4>
                                    <table id="example" class="display nowrap table table-bordered" cellspacing="0" width="100%">

                                        <tbody>

                                            <tr>
                                                <td>Student Name</td>
                                                <td><?= $student->name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Moblie Number</td>
                                                <td><?= $student->mobile ?></td>
                                            </tr>

                                            <tr>
                                                <td>Whatsapp Number</td>
                                                <td><?= $student->whatsapp_number ?></td>
                                            </tr>

                                            <tr>
                                                <td>Email ID</td>
                                                <td><?= $student->email ?></td>
                                            </tr>

                                            <tr>
                                                <td>Guardian Name</td>
                                                <td><?= $student->father_name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Guardian Mobile No.</td>
                                                <td><?= $student->guardian_mobile ?></td>
                                            </tr>

                                            <tr>
                                                <td>Guardian Occupation</td>
                                                <td><?= $student->guardian_occupation ?></td>
                                            </tr>

                                            <tr>
                                                <td>D.O.B</td>
                                                <td><?= $student->date_of_birth ?></td>
                                            </tr>

                                            <tr>
                                                <td>Gender</td>
                                                <td>
                                                    <?php
                                                    if ($student->gender == 'male') {
                                                        echo 'Male';
                                                    } elseif ($student->gender == 'female') {
                                                        echo 'Female';
                                                    } elseif ($student->gender == 'other') {
                                                        echo 'Other';
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>



                                            </tr>

                                            <tr>
                                                <td>School/College Name</td>
                                                <td><?= $student->institute_name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Class Name </td>
                                                <td><?= $student->class_name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Stream Name </td>
                                                <td><?= $student->stream_name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Religion </td>
                                                <td><?= $student->religion ?></td>
                                            </tr>


                                            <tr>
                                                <td>Full Address</td>
                                                <td><?= $student->address ?></td>
                                            </tr>

                                            <tr>
                                                <td>District Name</td>
                                                <td><?= $student->district_name ?></td>
                                            </tr>

                                            <tr>
                                                <td>Police Station</td>
                                                <td><?= $student->police_station ?></td>
                                            </tr>

                                            <tr>
                                                <td>PIN Code</td>
                                                <td><?= $student->pincode ?></td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body container common_list_table">
                            <div class="row">
                                <div class="container">

                                    <h4 class="card-title text-center text-primary mb-3">Student Membership Plan</h4>

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

                                        <?php } ?>
                                    </table>

                                    <div>
                                        <a href="<?= base_url('student/buy-subscription/' . $student->user_id) ?>" class="btn btn-primary mt-3">Buy or Renew Subscription</a>
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