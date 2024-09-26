<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo getCurrentController();  ?> - <?= getCurrentMethod() ?> | <?= env('app.name') ?? "School Shiksharthi Admin"; ?> </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url('')  ?>public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url('')  ?>public/assets/vendors/css/vendor.bundle.base.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= base_url('')  ?>public/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?= base_url('')  ?>public/assets/images/favicon.ico" />
    <!-- BsMultiSelect CSS and JS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.1/dist/css/bootstrap-select.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error-text {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word;
            word-break: break-word;
        }
    </style>
    <script src="<?= base_url('') ?>public/assets/ckeditor/ckeditor.js"></script>

    <link rel="stylesheet" href="<?= base_url('') ?>public/assets/css/jquery.dataTables.min.css">
</head>