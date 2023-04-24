<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/dashboard/add_role" class="btn btn-info btn-xs">Add New Role</a>
                    <a href="<?= base_url() ?>/dashboard/roles_permissions" class="btn btn-success btn-xs">Roles & Permissions</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>List Permissions</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="notificationArea"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="nav nav-tabs flex-column bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-administrator-tab" data-toggle="pill" href="#v-pills-administrator" role="tab" aria-controls="v-pills-administrator" aria-selected="true">Administrator</a>
<!--                                <a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                                <a class="nav-link" id="v-pills-partner-tab" data-toggle="pill" href="#v-pills-partner" role="tab" aria-controls="v-pills-partner" aria-selected="false">Partner</a>
                                <a class="nav-link" id="v-pills-domain-tab" data-toggle="pill" href="#v-pills-domain" role="tab" aria-controls="v-pills-domain" aria-selected="false">Domain</a>
                                <a class="nav-link" id="v-pills-hosting-tab" data-toggle="pill" href="#v-pills-hosting" role="tab" aria-controls="v-pills-hosting" aria-selected="false">Hosting</a>
                                <a class="nav-link" id="v-pills-service-tab" data-toggle="pill" href="#v-pills-service" role="tab" aria-controls="v-pills-service" aria-selected="false">Service</a>
                                <a class="nav-link" id="v-pills-crm-tab" data-toggle="pill" href="#v-pills-crm" role="tab" aria-controls="v-pills-crm" aria-selected="false">CRM</a>
                                <a class="nav-link" id="v-pills-sales-tab" data-toggle="pill" href="#v-pills-sales" role="tab" aria-controls="v-pills-sales" aria-selected="false">Sales</a>
                                <a class="nav-link" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="false">Account</a>-->
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-administrator" role="tabpanel" aria-labelledby="v-pills-administrator-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_profile" name="permission_name" value="view_profile" class="checkbox style-0">
                                                                <span>View Profile</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_profile" name="permission_name" value="edit_profile" class="checkbox style-0">
                                                                <span>Edit Profile</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_activity" name="permission_name" value="view_activity" class="checkbox style-0">
                                                                <span>View Activity</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_notification" name="permission_name" value="view_notification" class="checkbox style-0">
                                                                <span>View Notification</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="delete_notification" name="permission_name" value="delete_notification" class="checkbox style-0">
                                                                <span>Delete Notification</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_role" name="permission_name" value="view_role" class="checkbox style-0">
                                                                <span>View Role</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_role" name="permission_name" value="add_role" class="checkbox style-0">
                                                                <span>Add Role</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_role" name="permission_name" value="edit_role" class="checkbox style-0">
                                                                <span>Edit Role</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_permission" name="permission_name" value="edit_permission" class="checkbox style-0">
                                                                <span>Edit Permission</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="delete_permission" name="permission_name" value="delete_permission" class="checkbox style-0">
                                                                <span>Delete Permission</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_admin" name="permission_name" value="view_admin" class="checkbox style-0">
                                                                <span>View Admin</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>    
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_admin" name="permission_name" value="add_admin" class="checkbox style-0">
                                                                <span>Add Admin</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_setting" name="permission_name" value="view_setting" class="checkbox style-0">
                                                                <span>View Setting</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_setting" name="permission_name" value="add_setting" class="checkbox style-0">
                                                                <span>Edit Setting</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>                                     
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
<!--                                <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_customer" name="permission_name" value="view_customer" class="checkbox style-0">
                                                                <span>View Customer</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_customer" name="permission_name" value="add_customer" class="checkbox style-0">
                                                                <span>Add Customer</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_customer" name="permission_name" value="edit_customer" class="checkbox style-0">
                                                                <span>Edit Customer</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_fund" name="permission_name" value="view_fund" class="checkbox style-0">
                                                                <span>View Fund</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_fund" name="permission_name" value="add_fund" class="checkbox style-0">
                                                                <span>Add Fund</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_fund_transaction" name="permission_name" value="view_fund_transaction" class="checkbox style-0">
                                                                <span>View Fund Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-partner" role="tabpanel" aria-labelledby="v-pills-partner-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_partner" name="permission_name" value="view_partner" class="checkbox style-0">
                                                                <span>View Partner</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_partner" name="permission_name" value="add_partner" class="checkbox style-0">
                                                                <span>Add Partner</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_investment" name="permission_name" value="view_investment" class="checkbox style-0">
                                                                <span>View Investment</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_investment" name="permission_name" value="add_investment" class="checkbox style-0">
                                                                <span>Add Investment</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-domain" role="tabpanel" aria-labelledby="v-pills-domain-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_domain" name="permission_name" value="view_domain" class="checkbox style-0">
                                                                <span>View Domain</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_domain" name="permission_name" value="add_domain" class="checkbox style-0">
                                                                <span>Add Domain</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_domain" name="permission_name" value="edit_domain" class="checkbox style-0">
                                                                <span>Edit Domain</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="domain_renew" name="permission_name" value="domain_renew" class="checkbox style-0">
                                                                <span>Domain Renew</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="domain_invoice" name="permission_name" value="domain_invoice" class="checkbox style-0">
                                                                <span>View Invoice</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-4">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_domain_transaction" name="permission_name" value="view_domain_transaction" class="checkbox style-0">
                                                                <span>View Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_domain_transaction" name="permission_name" value="add_domain_transaction" class="checkbox style-0">
                                                                <span>Add Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-hosting" role="tabpanel" aria-labelledby="v-pills-hosting-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_hosting_package" name="permission_name" value="view_hosting_package" class="checkbox style-0">
                                                                <span>View Package</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_hosting_package" name="permission_name" value="add_hosting_package" class="checkbox style-0">
                                                                <span>Add Package</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_hosting_package" name="permission_name" value="edit_hosting_package" class="checkbox style-0">
                                                                <span>Edit Package</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_hosting" name="permission_name" value="view_hosting" class="checkbox style-0">
                                                                <span>View Hosting</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_hosting" name="permission_name" value="add_hosting" class="checkbox style-0">
                                                                <span>Add Hosting</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_hosting" name="permission_name" value="edit_hosting" class="checkbox style-0">
                                                                <span>Edit Hosting</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="hosting_renew" name="permission_name" value="hosting_renew" class="checkbox style-0">
                                                                <span>Hosting Renew</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="hosting_invoice" name="permission_name" value="hosting_invoice" class="checkbox style-0">
                                                                <span>View Invoice</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-4">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_hosting_transaction" name="permission_name" value="view_hosting_transaction" class="checkbox style-0">
                                                                <span>View Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_hosting_transaction" name="permission_name" value="add_hosting_transaction" class="checkbox style-0">
                                                                <span>Add Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-service" role="tabpanel" aria-labelledby="v-pills-service-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_service" name="permission_name" value="view_service" class="checkbox style-0">
                                                                <span>View Service</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_service" name="permission_name" value="add_service" class="checkbox style-0">
                                                                <span>Add Service</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="edit_service" name="permission_name" value="edit_service" class="checkbox style-0">
                                                                <span>Edit Service</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="service_extension" name="permission_name" value="service_extension" class="checkbox style-0">
                                                                <span>Service Extension</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="service_invoice" name="permission_name" value="service_invoice" class="checkbox style-0">
                                                                <span>View Invoice</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                                <div class="col-md-4">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_service_transaction" name="permission_name" value="view_service_transaction" class="checkbox style-0">
                                                                <span>View Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="add_service_transaction" name="permission_name" value="add_service_transaction" class="checkbox style-0">
                                                                <span>Add Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-crm" role="tabpanel" aria-labelledby="v-pills-crm-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_ticket" name="permission_name" value="view_ticket" class="checkbox style-0">
                                                                <span>View Ticket</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="reply_ticket" name="permission_name" value="reply_ticket" class="checkbox style-0">
                                                                <span>Reply Ticket</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-sales" role="tabpanel" aria-labelledby="v-pills-sales-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_sale" name="permission_name" value="view_sale" class="checkbox style-0">
                                                                <span>View Sale</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_sale_transaction" name="permission_name" value="view_sale_transaction" class="checkbox style-0">
                                                                <span>View Transaction</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                                    <ul class="list-unstyled">
                                        <li>
                                            <ul class="list-unstyled">
                                                <div class="col-md-3">
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_cashbook" name="permission_name" value="view_cashbook" class="checkbox style-0">
                                                                <span>View Cashbook</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_income" name="permission_name" value="view_income" class="checkbox style-0">
                                                                <span>View Income</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onchange="save_permission(this, <?= $role_id; ?>, this.value);" id="view_expense" name="permission_name" value="view_expense" class="checkbox style-0">
                                                                <span>View Expense</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </div>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End of Page Content -->
<script>
<?php foreach ($all_permissions as $permission) { ?>
        document.getElementById("<?= $permission['permission_name'] ?>").checked = <?= $permission['permission_name']; ?>;
<?php } ?>
</script>