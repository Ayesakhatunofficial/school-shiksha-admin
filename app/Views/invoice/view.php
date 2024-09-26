<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>School Shiksharthi Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

    <style type="text/css">
        body {
            margin-top: 20px;
            background-color: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="<?= session('logo') ?? ""; ?>" alt="" height="65" , width="250">
                        </div>

                        <div class="invoice-title">
                            <h4 class="float-end font-size-15">Invoice ID : <?= $invoice->uniq_invoice_id; ?>

                                <?php if ($invoice->status == 'paid') { ?>
                                    <span class="badge bg-success font-size-12 ms-2"><?= ucwords($invoice->status); ?></span>
                                <?php } else if ($invoice->status == 'unpaid') { ?>
                                    <span class="badge bg-danger font-size-12 ms-2"><?= ucwords($invoice->status); ?></span>
                                <?php } ?>

                            </h4>

                            <div class="mb-2">
                                <h3 class="mb-1 text-muted"><?= getSettingValue('company_name', $setting) ?></h3>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1"><?= getSettingValue('company_address', $setting) ?></p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2"><?= $invoice->user_name ?></h5>
                                    <?php if (isset($invoice->address)) { ?>
                                        <p class="mb-1"><?= $invoice->address ?></p>
                                    <?php } ?>
                                    <p class="mb-1"><?= $invoice->user_email ?></p>
                                    <p><?= $invoice->mobile ?></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                        <p><?= $invoice->uniq_invoice_id ?></p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p><?= $invoice->invoice_date ?></p>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1"><?= $invoice->item_description ?></h5>
                                                    <?php if (!empty($invoice->plan_description)) {
                                                        $desc = json_decode($invoice->plan_description);
                                                        foreach ($desc as $row) { ?>
                                                            <p class="text-muted mb-0"><?= $row ?></p>
                                                    <?php  }
                                                    } ?>
                                                </div>
                                            </td>
                                            <td>₹ <?= $invoice->amount ?></td>
                                            <td><?= $invoice->quantity ?></td>
                                            <td class="text-end">₹ <?= $invoice->total ?></td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                            <td class="text-end">₹ <?= $invoice->subtotal ?></td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Discount :</th>
                                            <td class="border-0 text-end"> - ₹ <?= $invoice->discount ?></td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                            <td class="border-0 text-end">
                                                <h5 class="m-0 fw-semibold"> ₹ <?= $invoice->total ?></h5>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="d-print-none mt-4">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                                    <!-- <a href="#" class="btn btn-primary w-md">Send</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>