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

                                    <h4 class="card-title text-center text-primary mb-3"> Student Enquiry Details</h4>
                                    <table id="details" class="display nowrap table table-bordered" cellspacing="0"
                                        width="100%">
                                        <?php if (!empty($details)) { ?>
                                            <tbody>
                                                <?php foreach ($details as $key => $value) { ?>
                                                    <tr>
                                                        <td><?= ucwords(str_replace('_', ' ', $key)) ?></td>
                                                        <td><?= $value ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php if (!empty($documents)) { ?>
                        <div class="card mt-3">
                            <div class="card-body container common_list_table">
                                <div class="row">
                                    <div class="container">

                                        <h4 class="card-title text-center text-primary mb-3">Student Documents</h4>

                                        <table id="example" class="display nowrap table table-bordered" cellspacing="0"
                                            width="100%">


                                            <tbody>
                                                <?php foreach ($documents as $document) { ?>
                                                    <tr>
                                                        <td><?= $document->title ?></td>
                                                        <td>
                                                            <?php
                                                            $check = checkFileType($document->image);
                                                            if ($check == 'Image') {
                                                                ?>
                                                                <img src="<?= $document->image ?>" alt="" target="blank">
                                                            <?php } else { ?>
                                                                <a href="<?= $document->image ?>"
                                                                    target="_blank"><?= $document->image ?></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>

                                                </tbody>

                                            <?php } ?>
                                        </table>


                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php }
                    if (!empty($enquiry) && $enquiry->status != 'completed') {
                        ?>
                        <div class="card mt-3">
                            <div class="card-body container common_list_table">
                                <div class="row">
                                    <div class="container">

                                        <h4 class="card-title text-center text-primary mb-3"> Enquiry Status</h4>

                                        <form class="row" action="" method="post" enctype="multipart/form-data">
                                            <div class="form-group col-lg-12">
                                                <label>Change Status<i class="mdi mdi-star color-danger"></i></label>

                                                <select name="status" id="status_value" class="form-control"
                                                    onclick="showRemarks()">
                                                    <option value="">select status</option>
                                                    <option value="pending" <?= ($enquiry->status == 'pending') ? "selected" : '' ?>>Pending</option>
                                                    <option value="completed" <?= ($enquiry->status == 'completed') ? "selected" : '' ?>>Completed</option>
                                                    <option value="rejected" <?= ($enquiry->status == 'rejected') ? "selected" : '' ?>>Rejected</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-lg-12" id="remark" style="display: none;">
                                                <label for="">Remarks</label>
                                                <textarea name="remarks" id="" class="form-control"
                                                    placeholder="Enter Remarks"><?= isset($enquiry->cancel_reason) ? $enquiry->cancel_reason : '' ?></textarea>
                                            </div>

                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                                <a class="btn btn-light"
                                                    href="<?= base_url('student/enquiry') ?>">Cancel</a>
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