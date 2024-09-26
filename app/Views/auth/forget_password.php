<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= getsetting('company_name') ?? 'School shiksharthi' ?> Admin</title>
    <link rel="stylesheet" href="<?= base_url('') ?>public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url('') ?>public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url('') ?>public/assets/css/style.css">
    <link rel="shortcut icon" href="<?= base_url('') ?>public/assets/images/favicon.ico" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<?php $session = session() ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">

                        <?= view('includes/msg.php') ?>

                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="<?= base_url('') ?>public/assets/images/logo.png">
                            </div>
                            <h4>Forgot your Password ? </h4>
                            <h6 class="font-weight-light "><small>Enter your email and we'll send you a link to reset your password.</small></h6>
                            <form class="pt-3" action="" id="loginForm" method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email <i class="mdi mdi-star color-danger"></i></label>
                                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Enter Your Registered Email" name="email" value="<?= old('email') ?>" required>
                                    <?= showValidationError('email') ?>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Submit</button>
                                </div>
                            </form>
                            <div class="mt-3 text-center">
                                <a href="<?= base_url() ?>" class="font-weight-medium text-black ">Back to Login</a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>