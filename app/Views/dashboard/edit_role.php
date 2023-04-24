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
        <div class="col-md-12 col-sm-12">
            <form id="role" method="post" class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role Name <span class="required">*</span></label>
                                <input type="text" name="name" required value="<?= $role_info['role_name'] ?>" class="form-control">
                                <input type="hidden" name="role_id" value="<?= $role_info['role_id'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control no-resize"><?= $role_info['role_description'] ?></textarea>
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
            $('#submit').attr('disabled', true);
            $('#submit').html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/dashboard/update_role',
                data: $('#role').serialize(),
                success: function (data)
                {
                    if (data === 'success') {
                        $('#submit').attr('disabled', true);
                        $('#notificationArea').html("<div class='alert alert-primary' role='alert'>Updated!</div>");
                    } else {
                        $('#submit').attr('disabled', false);
                        $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                    }
                    $('#submit').html('Update');
                }
            });
        });
    });
</script>