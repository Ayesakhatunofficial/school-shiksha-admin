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
                            <h4 class="card-title mb-3"> Organizations</h4>

                            <div class="row">
                                <div class="container">
                                    <div>
                                        <a href="<?= base_url('organization') ?>" class="btn btn-primary btn-sm mb-3">
                                            Add</a>
                                    </div>

                                    <table class="example display nowrap table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>Organization Name</th>
                                                <th>Organization Logo</th>
                                                <th>Organization Type</th>
                                                <th>Status</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($organizations)) {
                                                $i = 1;
                                                foreach ($organizations as $row) {
                                            ?>

                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= $row->name ?></td>
                                                        <td>
                                                            <img src="<?= $row->logo; ?>" alt=" image" width=50, height=50>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($row->type == 'college') {
                                                                echo 'College';
                                                            } else if ($row->type == 'others') {
                                                                echo 'Others';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row->is_active == 0) { ?>
                                                                <a>
                                                                    <label class="badge badge-danger">Inactive</label>
                                                                </a>

                                                            <?php } else if ($row->is_active == 1) { ?>

                                                                <a>
                                                                    <label class="badge badge-success">Active</label>
                                                                </a>

                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <div class="main_curd">
                                                                <a href="<?= base_url('organization/edit/' . $row->id) ?>" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </a>
                                                                <a href="<?= base_url('organization/delete/' . $row->id) ?>" class="btn a-btn btn-inverse-danger btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are You Sure?')">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </a>
                                                                <!-- Replace $row->id with the actual variable containing the organization ID -->
                                                                <a href="<?= base_url('organization/' . $row->id . '/course') ?>" class="btn a-btn btn-inverse-warning btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Organization Courses">
                                                                    <i class="mdi mdi-book-open"></i>
                                                                </a>
                                                                <a href="<?= base_url('organization/' . $row->id . '/banner') ?>" class="btn a-btn btn-inverse-info btn-rounded btn-icon" data-toggle="tooltip" data-placement="top" title="Organization Banner">
                                                                    <i class="mdi mdi-image"></i>
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
