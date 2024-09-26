<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">



        <li class="nav-item">
            <a class="nav-link " href="<?= base_url('') ?>">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <?php
        $role = getRole();
        if (isset($role) && $role == ROLE_SUPER_ADMIN) {
        ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#masters" aria-expanded="false" aria-controls="masters">
                    <span class="menu-title">Master</span>
                    <i class="menu-arrow"></i>
                </a>

                <div class="collapse <?= (current_url() == base_url('addstates') || current_url() == base_url('states') || current_url() == base_url('addDistrict') || current_url() == base_url('district') || current_url() == base_url('addBlocks') || current_url() == base_url('blocks') || current_url() == base_url('organization') || current_url() == base_url('organization/view') || current_url() == base_url('course') || current_url() == base_url('course/view') || current_url() == base_url('category') || current_url() == base_url('category/view') || current_url() == base_url('addplans') || current_url() == base_url('plans') || current_url() == base_url('addcommsion') || current_url() == base_url('commsion') || current_url() == base_url('addnotification') || current_url() == base_url('notification')) ? 'show' : '' ?>" id="masters">

                    <ul class="nav flex-column sub-menu">

                        <li class="submenu-item ">
                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="state">
                                <span class="menu-title">States</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="state">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addstates')) ? 'active' : '' ?>" href="<?= base_url('addstates') ?>">Add States</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('states')) ? 'active' : '' ?>" href="<?= base_url('states') ?>">View States</a></li>
                                </ul>
                            </div>
                        </li>


                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="district">
                                <span class="menu-title">District</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="district">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addDistrict')) ? 'active' : '' ?>" href="<?= base_url('addDistrict') ?>">Add
                                            District</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('district')) ? 'active' : '' ?>" href="<?= base_url('district') ?>">View
                                            District</a></li>
                                </ul>
                            </div>

                        </li>

                        <li class="submenu-item ">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="block">
                                <span class="menu-title">Block</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="block">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addBlocks')) ? 'active' : '' ?>" href="<?= base_url('addBlocks') ?>">Add
                                            Block</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('blocks')) ? 'active' : '' ?>" href="<?= base_url('blocks') ?>">View
                                            Block</a></li>
                                </ul>
                            </div>

                        </li>


                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="organization">
                                <span class="menu-title">Organization</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="organization">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('organization')) ? 'active' : '' ?>" href="<?= base_url('organization') ?>">Add
                                            Organization</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('organization/view')) ? 'active' : '' ?>" href="<?= base_url('organization/view') ?>">View
                                            Organization</a></li>
                                </ul>
                            </div>

                        </li>


                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="course">
                                <span class="menu-title">Course</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="course">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('course')) ? 'active' : '' ?>" href="<?= base_url('course') ?>">Add
                                            Course</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('course/view')) ? 'active' : '' ?>" href="<?= base_url('course/view') ?>">View
                                            Course</a></li>
                                </ul>
                            </div>

                        </li>
                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="category">
                                <span class="menu-title">Service</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="category">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('category')) ? 'active' : '' ?>" href="<?= base_url('category') ?>">Add
                                            Service</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('category/view')) ? 'active' : '' ?>" href="<?= base_url('category/view') ?>">View
                                            Service</a></li>
                                </ul>
                            </div>

                        </li>

                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="plan">
                                <span class="menu-title">Plan</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="class">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addplans')) ? 'active' : '' ?>" href="<?= base_url('addplans') ?>">Add
                                            Plan</a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('plans')) ? 'active' : '' ?>" href="<?= base_url('plans') ?>">View Plan</a>
                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="commission">
                                <span class="menu-title">Commission</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="commission">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addcommsion')) ? 'active' : '' ?>" href="<?= base_url('addcommsion'); ?>">Add
                                            Commission</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('commsion')) ? 'active' : '' ?>" href="<?= base_url('commsion'); ?>">View
                                            Commission</a>
                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li class="submenu-item">

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="commission">
                                <span class="menu-title">Notification</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="commission">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addnotification')) ? 'active' : '' ?>" href="<?= base_url('addnotification'); ?>">Add
                                            Notification</a></li>
                                    <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('notification')) ? 'active' : '' ?>" href="<?= base_url('notification'); ?>">View
                                            Notification</a>
                                    </li>
                                </ul>
                            </div>

                        </li>


                        <li class="submenu-item">
                            <a class="nav-link <?= current_url() == base_url('dashboard/banner') ? 'active' : '' ?>" href="<?= base_url('dashboard/banner') ?>">
                                <span class="menu-title">Dashboard Banner</span>
                            </a>
                        </li>

                        <li class="submenu-item">
                            <a class="nav-link <?= current_url() == base_url('banner') ? 'active' : '' ?>" href="<?= base_url('banner') ?>">
                                <span class="menu-title">Banner</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        <?php
        }
        if (isset($role) && $role == ROLE_SUPER_ADMIN || $role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR) {
        ?>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
                    <span class="menu-title">User</span>
                    <i class="menu-arrow"></i>
                </a>

                <div class="collapse" id="user">
                    <ul class="nav flex-column sub-menu">

                        <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('addusers')) ? 'active' : '' ?>" href="<?= base_url('addusers'); ?>">Add
                                Users</a></li>

                        <?php
                        $md_role_id = getRoleId(ROLE_MASTER_DISTRIBUTOR);
                        $d_role_id = getRoleId(ROLE_DISTRIBUTOR);
                        $a_role_id = getRoleId(ROLE_AFFILATE_AGENT);
                        if ($role == ROLE_SUPER_ADMIN) {
                        ?>

                            <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('users/' . $md_role_id)) ? 'active' : '' ?>" href="<?= base_url('users/' . $md_role_id); ?>">Master
                                    Distributor</a>
                            </li>
                        <?php }
                        if ($role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_SUPER_ADMIN) {
                        ?>
                            <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('users/' . $d_role_id)) ? 'active' : '' ?>" href="<?= base_url('users/' . $d_role_id); ?>">Distributor</a>
                            </li>
                        <?php
                        }
                        if ($role == ROLE_SUPER_ADMIN || $role == ROLE_DISTRIBUTOR) {
                        ?>
                            <li class="nav-item"> <a class="nav-link <?= (current_url() == base_url('users/' . $a_role_id)) ? 'active' : '' ?>" href="<?= base_url('users/' . $a_role_id); ?>">Affiliate
                                    Agent</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>


        <?php }

        $user = getUserData();
        if (isset($role) && $role == ROLE_AFFILATE_AGENT || $role == ROLE_DISTRIBUTOR || $role == ROLE_MASTER_DISTRIBUTOR) { ?>

            <li class="nav-item <?= (current_url() == base_url('user/plan/' . $user->id)) ? 'show' : '' ?>">
                <a class="nav-link <?= (current_url() == base_url('user/plan/' . $user->id)) ? 'active' : '' ?>" href="<?= base_url('user/plan/' . $user->id) ?>">
                    Plan
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= (current_url() == base_url('user/' . $user->id . '/invoice')) ? 'active' : '' ?>" href="<?= base_url('user/' . $user->id . '/invoice') ?>">
                    Invoice
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/bank_details') ?>">
                    Bank Details
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= (current_url() == base_url('user/' . $user->id . '/withdraw-request')) ? 'active' : '' ?>" href="<?= base_url('user/' . $user->id . '/withdraw-request') ?>">
                    Withdraw Wallet Balance
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/' . $user->id . '/wallet') ?>">
                    Wallet History
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/commissions') ?>">
                    Commissions
                </a>
            </li>

        <?php }
        if (isset($role) && $role == ROLE_AFFILATE_AGENT || $role == ROLE_SUPER_ADMIN) { ?>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#student" aria-expanded="false" aria-controls="student">
                    <span class="menu-title">Student</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse <?= (current_url() == base_url('student/view/free-students') || current_url() == base_url('student/view/paid-students')) ? 'show' : '' ?>" id="student">
                    <ul class="nav flex-column sub-menu">

                        <li class="submenu-item">

                            <a class="nav-link <?= (current_url() == base_url('student/add')) ? 'active' : '' ?>" href="<?= base_url('student/add') ?>" aria-expanded="false" aria-controls="add_student">
                                <span class="menu-title">Add Student</span>
                            </a>

                            <a class="nav-link" href="javascript:void(0)" aria-expanded="false" aria-controls="view_student">
                                <span class="menu-title">View Student</span>
                                <i class="menu-arrow"></i>
                            </a>

                            <div class="collapse" id="view_student">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('student/view/free-students') ?>">Free
                                            Student</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('student/view/paid-students') ?>">Paid
                                            Student</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('students') ?>">Students</a></li>
                                </ul>
                            </div>

                        </li>
                    </ul>
                </div>
            </li>

        <?php }

        if (isset($role) && $role == ROLE_SUPER_ADMIN) { ?>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/student/enquiry') ?>">
                    <span class="menu-title">Student Enquiry</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/studentQuery') ?>">
                    Student Query
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/withdraw-request') ?>">
                    Withdrawal Request
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/wallet-history') ?>">
                    Wallet History
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/careerGuidence') ?>">
                    <span class="menu-title">Career Guidance</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/external-records') ?>">
                    <span class="menu-title">External Records</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/purchase-history') ?>">
                    <span class="menu-title">Purchase History</span>
                </a>
            </li>

        <?php } ?>

    </ul>
</nav>
<!-- partial -->