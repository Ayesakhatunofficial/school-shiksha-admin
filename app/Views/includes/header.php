<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 d-flex flex-row fixed-top">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

        <a class="navbar-brand brand-logo" href="<?= base_url('') ?>"><img src="<?= session('logo') ?? ""; ?>" style="height: 50px;" alt="logo"></a>

        <a class="navbar-brand brand-logo-mini" href="<?= base_url('') ?>"><img src="<?= base_url('')  ?>public/assets/images/logo-mini.svg" alt="logo"></a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <?php
        $role = getRole();
        if ($role == ROLE_AFFILATE_AGENT || $role == ROLE_DISTRIBUTOR || $role == ROLE_MASTER_DISTRIBUTOR) {
        ?>
            <div class="text-center wallet-balance d-flex align-items-center justify-content-center">
                <button class="btn btn-primary align-self-center">
                    Wallet Balance : ₹ <?= getWallet(); ?>
                </button>
            </div>
            <?php
            $notification = [];
            $notification = getNotification();
            ?>
            <li class="nav-item dropdown justify-content-end">
                <a class="nav-link" data-toggle="dropdown" href="#" id="notificationDropdown">
                    <i class="far fa-bell"></i>
                    <?php if (isset($notification) && count($notification) > 0) { ?>
                        <span class="badge badge-danger navbar-badge" id="notificationBadge"><?= checkNotification(); ?></span>
                    <?php } ?>
                </a>
                <input type="hidden" id="notificationUserId" value="<?= $notification[0]['user_id'] ?? ""; ?>">
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <?php if (isset($notification) && !empty($notification)) {
                        foreach ($notification as $notification_row) { ?>
                            <a href="javascript:void(0)" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="dropdown-item-title">
                                            <?= isset($notification_row['subject']) ? htmlspecialchars($notification_row['subject']) : ""; ?>
                                        </h5>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?= isset($notification_row['created_at']) ? timeElapsedString($notification_row['created_at']) : ""; ?></p>
                                    </div>
                                    <span class="ml-auto text-danger"><i class="fas fa-star"></i></span>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                        <?php } ?>
                        <a href="<?= base_url('notification/fetchNotification/') . $notification_row['user_id'] ?>" class="dropdown-item dropdown-footer" id="NotifyMessages">See All Messages</a>
                    <?php } else { ?>
                        <a href="#" class="dropdown-item">No Messages</a>
                    <?php } ?>
                </div>
            </li>
        <?php
        }
        ?>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-text">
                        <?php $user = getUserData(); ?>
                        <p class="mb-1 text-black"><?= $user->name ?? ""; ?></p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?= base_url('profile') ?>">
                        <i class="mdi mdi-account mr-2 text-success"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <?php if ($role == ROLE_SUPER_ADMIN) { ?>
                        <a class="dropdown-item" href="<?= base_url('setting') ?>">
                            <i class="mdi mdi-cached mr-2 text-success"></i>Settings</a>
                        <div class="dropdown-divider"></div>
                    <?php } ?>
                    <a class="dropdown-item" href="<?= base_url('logout') ?>" onclick="return confirm('Are You Sure?')">
                        <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
                </div>
            </li>

            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>


</nav>