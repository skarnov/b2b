<!DOCTYPE html>

<html lang="en">
    <head>
        <meta name="robots" content="noindex" />
        <meta name="googlebot" content="noindex">
        <meta name="googlebot-news" content="nosnippet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ? $title : $settings['project_name'] ?></title>
        <!-- Favicon -->
        <link href="<?= base_url() ?>/assets/frontend/img/favicon.ico" rel="icon">
        <!-- Bootstrap -->
        <link href="<?= base_url() ?>/assets/backend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- Font Awesome -->
        <link href="<?= base_url() ?>/assets/backend/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
        <!-- Data Table -->
        <link href="<?= base_url() ?>/assets/backend/vendor/datatable/datatables.min.css" rel="stylesheet"/>
        <link href="<?= base_url() ?>/assets/backend/vendor/datatable/buttons.dataTables.min.css" rel="stylesheet"/>
        <!-- iCheck -->
        <link href="<?= base_url() ?>/assets/backend/vendor/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?= base_url() ?>/assets/backend/css/style.css" rel="stylesheet">
    </head>

    <body class="nav-md">
        <script>
            var jQ = new Array();
        </script>
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?= base_url() ?>" target="_blank" class="site_title"><span><?= $settings['project_name'] ?></span></a>
                        </div>
                        <div class="clearfix"></div>
                        <!-- Menu Profile -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <?php if ($admin_image): ?>
                                    <img src="<?= base_url() . '/uploads/profile_image/' . $admin_image ?>" class="img-circle profile_img">
                                <?php else: ?>
                                    <img src="<?= base_url() ?>/assets/backend/img/default/user.png" class="img-circle profile_img">
                                <?php endif ?>
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2 class="text-capitalize"><?= $user_name ?></h2>
                            </div>
                        </div>
                        <br/>
                        <!-- Sidebar Menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li><a href="<?= base_url() ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                    <?php if ($permissions == 'superadmin' || array_search('view_activity', $permissions) || array_search('view_role', $permissions) || array_search('view_admin', $permissions) || array_search('view_settings', $permissions) || array_search('view_maintenance', $permissions)): ?>
                                        <li><a><i class="fa fa-building"></i> Administration <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_activity', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/dashboard/manage_activities">User Activities</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_role', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/dashboard/roles_permissions">Role & Permission</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_admin', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/dashboard/admins">Admins</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_settings', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/dashboard/settings">Settings</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_maintenance', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/dashboard/maintenance">Maintenance</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_user', $permissions) || array_search('add_fund', $permissions) || array_search('view_fund', $permissions) || array_search('view_fund_transaction', $permissions)): ?>
                                        <li><a><i class="fa fa-cloud"></i> User <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_user', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/user">Users</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('add_fund', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/user/add_fund">Add Fund</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_fund', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/user/manage_funds">Fund Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_fund_transaction', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/user/fund_transactions">Transaction Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_partner', $permissions) || array_search('add_investment', $permissions) || array_search('view_investment', $permissions)): ?>
                                        <li><a><i class="fa fa-cloud"></i> Partner <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_partner', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/partner">Partner Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('add_investment', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/partner/add_investment">Add Investment</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_investment', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/partner/investment_transactions">Transaction Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_domain', $permissions) || array_search('view_domain_transaction', $permissions)): ?>
                                        <li><a><i class="fa fa-life-bouy"></i> Domains <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_domain', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/domain">Domain Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_domain_transaction', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/domain/transactions">Transaction Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_hosting_package', $permissions) || array_search('view_hosting', $permissions) || array_search('view_hosting_transaction', $permissions)): ?>
                                        <li><a><i class="fa fa-database"></i> Hosting <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_hosting_package', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/hosting/packages">Hosting Package</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_hosting', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/hosting">Hosting Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_hosting_transaction', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/hosting/transactions">Transaction Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_service', $permissions) || array_search('view_service_transaction', $permissions)): ?>
                                        <li><a><i class="fa fa-cube"></i> Service <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_service', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/service">Service Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_service_transaction', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/service/transactions">Transaction Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_ticket', $permissions)): ?>
                                        <li><a><i class="fa fa-tasks"></i> CRM <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="<?= base_url() ?>/email">Send Email</a></li>
                                                <li><a href="<?= base_url() ?>/ticket">Ticket Management</a></li>
                                                <li><a href="<?= base_url() ?>/message">Messages</a></li>
                                                <li><a href="<?= base_url() ?>/newsletter">Subscribed Email</a></li>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_sale', $permissions) || array_search('view_sale_transaction', $permissions)): ?>
                                        <li><a><i class="fa fa-barcode"></i> Sales <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_sale', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/account">Sale Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_sale_transaction', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/account/transactions">Transaction Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($permissions == 'superadmin' || array_search('view_cashbook', $permissions) || array_search('view_income', $permissions) || array_search('view_expense', $permissions)): ?>
                                        <li><a><i class="fa fa-calculator"></i> Account <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <?php if ($permissions == 'superadmin' || array_search('view_cashbook', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/account/cashbook">Cashbook</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_income', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/account/income">Income Management</a></li>
                                                <?php endif ?>
                                                <?php if ($permissions == 'superadmin' || array_search('view_expense', $permissions)): ?>
                                                    <li><a href="<?= base_url() ?>/account/expense">Expense Management</a></li>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                    <li><a><i class="fa fa-home"></i> About</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Top Navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <nav class="nav navbar-nav">
                            <ul class=" navbar-right">
                                <li class="nav-item dropdown open" style="padding-left: 15px;">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                        <?php if ($admin_image): ?>
                                            <img src="<?= base_url() . '/uploads/profile_image/' . $admin_image ?>">
                                        <?php else: ?>
                                            <img src="<?= base_url() ?>/assets/backend/img/default/user.png">
                                        <?php endif ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                        <?php if ($permissions == 'superadmin' || array_search('view_profile', $permissions)): ?>
                                            <a class="dropdown-item" href="<?= base_url() ?>/dashboard/profile"> Profile</a>
                                        <?php endif ?>
                                        <?php if ($permissions == 'superadmin' || array_search('view_setting', $permissions)): ?>
                                            <a class="dropdown-item" href="<?= base_url() ?>/dashboard/settings">
                                                <span>Settings</span>
                                            </a>
                                        <?php endif ?>
                                        <a class="dropdown-item" href="<?= base_url() ?>/login/admin_logout"><i class="fa fa-sign-out pull-right"></i> Logout</a>
                                    </div>
                                </li>
                                <li role="presentation" class="nav-item dropdown open">
                                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="badge bg-green"><?= $unseen_notifications ? $unseen_notifications : 0 ?></span>
                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                                        <?php
                                        foreach ($all_notifications as $notification) :
                                            ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>/dashboard/view_notification/<?= $notification['notification_id'] ?>" class="dropdown-item">
                                                    <span>
                                                        <span><?= $notification['notification_title'] ?></span>
                                                        <span class="time"><?= time_elapsed_string($notification['create_date'] . ' ' . $notification['create_time']); ?></span>
                                                    </span>
                                                    <span class="message">
                                                        <?= $notification['notification'] ?>
                                                    </span>
                                                </a>
                                            </li>
                                            <?php
                                        endforeach
                                        ?>
                                        <li class="nav-item">
                                            <div class="text-center">
                                                <a href="<?= base_url() ?>/dashboard/manage_notifications" class="dropdown-item">
                                                    <strong>See All Alerts</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <?= $home ?>
            </div>
            <!-- Footer Content -->
            <footer>
                <div class="pull-right">
                    &copy; Evis Technology 2013 - <?= date('Y') ?>. All Rights Reserved
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
        <!-- jQuery -->
        <script src="<?= base_url() ?>/assets/backend/vendor/jquery/jquery-3.5.1.js"></script>
        <!-- Bootstrap -->
        <script src="<?= base_url() ?>/assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Parsley -->
        <script src="<?= base_url() ?>/assets/backend/vendor/parsley/parsley.min.js"></script>
        <!-- iCheck -->
        <script src="<?= base_url() ?>/assets/backend/vendor/iCheck/icheck.min.js"></script>
        <!-- jQuery Form -->
        <script src="<?= base_url() ?>/assets/backend/vendor/jquery/jquery.form.min.js"></script>
        <!-- Data Table -->
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/datatables.min.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/dataTables.buttons.min.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/buttons.flash.min.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/jszip.min.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/pdfmake.min.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/vfs_fonts.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/buttons.html5.min.js"></script>
        <script src="<?= base_url() ?>/assets/backend/vendor/datatable/buttons.print.min.js"></script>
        <!-- Tinymce -->        
        <script src="<?= base_url() ?>/assets/backend/vendor/tinymce/tinymce.min.js"></script>        
        <!-- Custom Theme Scripts -->
        <script src="<?= base_url() ?>/assets/backend/js/custom.min.js"></script>
        <script>
            for (var i in jQ) {
                jQ[i]();
            }

            function findCustomerBalance(Id) {
                $("#submit").attr("disabled", true);
                $("#submit").html('Executing..');
                $.ajax({
                    url: "<?= base_url() ?>/user/findCustomerBalance/" + Id,
                    type: "POST",
                    success: function (data) {
                        $("#submit").html('Save');
                        $("#submit").attr("disabled", false);
                        $("#balance").val(data);
                    }
                });
            }

            function findPartnerInvestment(Id) {
                $("#submit").attr("disabled", true);
                $("#submit").html('Executing..');
                $.ajax({
                    url: "<?= base_url() ?>/partner/ /" + Id,
                    type: "POST",
                    success: function (data) {
                        $("#submit").html('Save');
                        $("#submit").attr("disabled", false);
                        $("#balance").val(data);
                    }
                });
            }

            function findSaleDue(Id) {
                $("#submit").attr("disabled", true);
                $("#submit").html('Executing..');
                $.ajax({
                    url: "<?= base_url() ?>/hosting/findSaleDue/" + Id,
                    type: "POST",
                    success: function (data) {
                        $("#submit").html('Save');
                        $("#submit").attr("disabled", false);
                        $("#balance").val(data);
                    }
                });
            }

            function save_permission(ths, rollId, permissionName) {
                if ($(ths).is(":checked")) {
                    $.ajax({
                        type: 'GET',
                        url: '<?= base_url() ?>/dashboard/update_permission/' + rollId + '/' + permissionName,
                        beforeSubmit: function () {
                            $("#notificationArea").hide();
                            $("#progressDivId").css("display", "block");
                            var percentValue = '0%';

                            $('#progressBar').width(percentValue);
                            $('#percent').html(percentValue);
                            $("#submit").attr("disabled", true);
                            $("#submit").html('Processing..');
                        },

                        error: function (xhr) {
                            $("#progressDivId").hide();
                            $("#notificationArea").html("<div class='alert alert-danger'>" + xhr.responseText + "</div>");
                        },

                        complete: function (xhr) {
                            $("#notificationArea").show();
                            var result = JSON.parse(xhr.responseText);
                            if (result.type == 'error') {
                                $("#progressDivId").hide();
                                $("#notificationArea").html("<div class='alert alert-danger'>" + result.msg + "</div>");
                            } else {
                                $("#notificationArea").html("<div class='alert alert-success'>" + result.msg + "</div>");
                                $("#progressDivId").hide();
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'GET',
                        url: '<?= base_url() ?>/dashboard/delete_permission/' + rollId + '/' + permissionName,
                        beforeSubmit: function () {
                            $("#notificationArea").hide();
                            $("#progressDivId").css("display", "block");
                            var percentValue = '0%';

                            $('#progressBar').width(percentValue);
                            $('#percent').html(percentValue);
                            $("#submit").attr("disabled", true);
                            $("#submit").html('Processing..');
                        },

                        error: function (xhr) {
                            $("#progressDivId").hide();
                            $("#notificationArea").html("<div class='alert alert-danger'>" + xhr.responseText + "</div>");
                        },

                        complete: function (xhr) {
                            $("#notificationArea").show();
                            var result = JSON.parse(xhr.responseText);
                            if (result.type == 'error') {
                                $("#progressDivId").hide();
                                $("#notificationArea").html("<div class='alert alert-danger'>" + result.msg + "</div>");
                            } else {
                                $("#notificationArea").html("<div class='alert alert-danger'>" + result.msg + "</div>");
                                $("#progressDivId").hide();
                            }
                        }
                    });
                }
            }
        </script>
    </body>
</html>