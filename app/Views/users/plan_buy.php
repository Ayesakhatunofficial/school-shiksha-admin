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
                    <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                    <div class="row">

                        <?php
                        if (!empty($plans)) {
                            foreach ($plans as $row) { ?>

                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="d-flex">
                                                <div class="content">
                                                    <p class="mb-2"><?= $row['plan_name'] ?></p>

                                                    <h5 class="mb-2">
                                                        <i class="mdi mdi-currency-inr"></i><?= $row['plan_amount'] ?>
                                                    </h5>

                                                    <p>Duration - <?= $row['plan_duration'] ?> Month</p>

                                                </div>
                                                <div class="icon">
                                                    <div class="rounded-circle ml-3">
                                                        <i class="mdi mdi-book-multiple-variant" width="50"></i>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>

                                        <input type="hidden" value="<?= $user_id ?>" id="user_id">

                                        <div class="card-footer bg-transparent">
                                            <div class="text-center">
                                                <!-- <input type="submit" class="btn btn-primary btn-sm" value="Buy Now"> -->

                                                <?php
                                                if (isset($current_plan->plan_id) && $current_plan->plan_id == $row['id']) { ?>
                                                    <button disabled class="btn btn-primary btn-sm">
                                                        Current Plan
                                                    </button>
                                                <?php } else if (isset($current_plan->plan_amount) && $current_plan->plan_amount > $row['plan_amount']) { ?>
                                                    <button class="btn btn-primary btn-sm" disabled>
                                                        Buy Now
                                                    </button>
                                                <?php } else { ?>
                                                    <button onclick="initiatePaymentProcess(<?= $row['id'] ?>);" class="btn btn-primary btn-sm">
                                                        Buy Now
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php }
                        } ?>

                    </div>
                    <!-- </form> -->

                </div>

                <!--  Small modal example -->
                <div class="modal fade bs-example-modal-sm" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mySmallModalLabel">Payment QR Code</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="col-md-12 text-center">
                                    <hr>
                                    <div class="text-dark"><b>Scan QR code using BHIM or your preferred UPI app</b></div>
                                    <div class="col-md-12 text-center mt-1">
                                        <div class="text-center">
                                            <img src="<?php echo base_url('public/assets/img/gpay.png'); ?>" alt="gpay" height="20px">
                                            <img src="<?php echo base_url('public/assets/img/paytm.png'); ?>" alt="gpay" height="20px">
                                            <img src="<?php echo base_url('public/assets/img/phonepe.png'); ?>" alt="gpay" height="20px">
                                            <img src="<?php echo base_url('public/assets/img/bhim_logo.png'); ?>" alt="gpay" height="20px">
                                            <img src="<?php echo base_url('public/assets/img/amazonpay.png'); ?>" alt="gpay" height="20px">
                                        </div>
                                        <div class="mt-2 d-flex justify-content-center" id="qrcode" style="max-width:100%">
                                            <img src="<?php echo base_url('public/assets/img/loading.cc387905.gif'); ?>" alt="" width="200">
                                        </div>
                                        <a href="#" id="upilink" class="btn bg-primary text-white btn-sm mt-2 upilink" style="display:none;">Pay ₹1.00 using a UPI App</a><br>

                                        <span class="text-center font-weight-bold">This QR code will expire in <span id="upitimer"></span></span></p>

                                        <div>
                                            <span style="color: green;" id="transaction_status"></span>
                                        </div>
                                        <div class="col-md-12 text-center mt-0">
                                            <img src="<?php echo base_url('public/assets/img/rectangle.png'); ?>" alt="" style="width: 60%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <?= view('includes/footer.php') ?>

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <?= view('includes/script.php') ?>
    <script src="<?php echo base_url(); ?>public/assets/js/custom-new.js?<?= time() ?>"></script>
    <script src="<?php echo base_url(); ?>public/assets/js/qrcode.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function upiTimer() {
            let timerNode = document.getElementById("upitimer");
            let totalTimer = 300;
            let interValId = setInterval(() => {
                totalTimer = totalTimer - 1;
                if (totalTimer == 0) {
                    window.location.href = '<?= base_url('user/buy-subscription/' . $user_id) ?>';
                    return;
                }
                Timer(timerNode, totalTimer);
            }, 1000);
        }
    </script>

    <script>
        var intervalId;

        function initiatePaymentProcess(id) {
            var user_id = document.getElementById("user_id").value;

            $.ajax({
                url: "<?php echo base_url('user/initiatePaymentProcess'); ?> ",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                data: {
                    id: id,
                    user_id: user_id
                },
                beforeSend: function() {
                    //
                },
                complete: function() {
                    //
                },
                success: function(response) {
                    console.log(response);
                    if (response.status) {

                        const data = response.upi_intent
                        $('#qrcodeModal').modal('show');
                        upiTimer();
                        setTimeout(function() {
                            document.getElementById("qrcode").innerHTML = '';
                            GenerateQR(data.upi_link, );
                            var upilink = document.getElementById("qrcode").title;

                            document.getElementById("upilink").href = upilink;

                        }, 1500);

                        setTimeout(function() {
                            intervalId = setInterval(function() {
                                makeAjaxCall(response.client_orderid, id);
                            }, 4000);
                        }, 30000);
                    } else {
                        alert(response.message);
                    }
                }
            })

        }


        function makeAjaxCall(orderId, id) {
            console.log("makeAjax function called");

            var user_id = document.getElementById("user_id").value;

            $.ajax({
                url: '<?php echo base_url('/user/paytmTxn-Status') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    orderId: orderId,
                    user_id: user_id,
                    plan_id: id
                },
                success: function(response) {
                    console.log(response.status);
                    if (response.status == 'SUCCESS') {
                        console.log("update status function called");
                        document.getElementById("transaction_status").innerHTML = 'Transaction Successfull';
                        setTimeout(function() {
                            $('#qrcodeModal').modal('hide');
                            clearInterval(intervalId);
                        }, 1000);
                        window.location.href = '<?= base_url(sprintf('user/buy-subscription/%s?payment_status=success', $user_id)) ?>';
                    }

                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>

</body>

</html>