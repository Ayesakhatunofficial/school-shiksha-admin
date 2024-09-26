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

    <style>
        .field-icon {
            float: right;
            margin-right: 15px;
            margin-top: -34px;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }
    </style>
</head>

<?php $session = session() ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="<?= base_url('') ?>public/assets/images/logo.png">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" action="<?= base_url('login') ?>" id="loginForm" method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email <i class="mdi mdi-star color-danger"></i></label>
                                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Enter Email" name="email" value="<?= old('email') ?>" required>
                                    <div class="text-danger"><?php echo $session->getFlashdata('name_error'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password <i class="mdi mdi-star color-danger"></i></label>
                                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" value="<?= old('password') ?>" placeholder="Enter Password" name="password" required>
                                    <span toggle="#exampleInputPassword1" class="mdi mdi-eye field-icon toggle-password"></span>
                                    <div class="text-danger"><?php echo $session->getFlashdata('pass_error'); ?></div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Submit</button>
                                </div>
                            </form>
                            <div class="mt-3 text-center">
                                <a href="<?= base_url('forget-password') ?>" class="font-weight-medium text-black ">Forget Password ?</a>
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
    <script>
        $(document).ready(function() {
            $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter password",
                    }
                },
                errorClass: "text-danger",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
        $(".toggle-password").click(function() {
            $(this).toggleClass("mdi-eye mdi-eye-off");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>

</html>