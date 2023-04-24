<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/hosting/packages" class="btn btn-secondary btn-xs">Manage Packages</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="package" method="post" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Package Name <span class="required">*</span></label>
                                <input type="text" name="package_name" required="required" value="<?= $package_info['package_name'] ?>" class="form-control">
                                <input type="hidden" name="package_id" value="<?= $package_info['package_id'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Package Price <span class="required">*</span></label>
                                <input type="number" name="package_price" required="required" value="<?= $package_info['package_price'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Website Host <span class="required">*</span></label>
                                <input type="number" name="website_host" required="required" value="<?= $package_info['website_host'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Database Host <span class="required">*</span></label>
                                <input type="number" name="database_host" required="required" value="<?= $package_info['database_host'] ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Package Storage <span class="required">*</span></label>
                                <input type="number" name="package_storage" required="required" value="<?= $package_info['package_storage'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>FTP Account <span class="required">*</span></label>
                                <input type="number" name="ftp_account" required="required" value="<?= $package_info['ftp_account'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email Account <span class="required">*</span></label>
                                <input type="number" name="email_account" required="required" value="<?= $package_info['email_account'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="package_status" class="form-control">
                                    <option value="active" <?= ($package_info['package_status'] == 'active') ? 'active' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($package_info['package_status'] == 'inactive') ? 'inactive' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" id="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Page Content -->
<script>
    jQ.push(function () {
        $('#submit').click(function (e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/hosting/update_package',
                data: $('#package').serialize(),
                success: function (data)
                {
                    if (data === 'success') {
                        $("#submit").attr("disabled", true);
                        $('#notificationArea').html("<div class='alert alert-primary' role='alert'>Update!</div>");
                    } else {
                        $("#submit").attr("disabled", false);
                        $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                    }
                    $("#submit").html('Save');
                }
            });
        });
    });
</script>